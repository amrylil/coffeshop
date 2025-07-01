<?php

namespace App\Http\Controllers;

use App\Models\ItemKeranjang;
use App\Models\Keranjang;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransaksiController extends Controller
{
    // ============= USER FUNCTIONS =============

    /**
     * Display user's transaction history
     */
    public function userIndex(Request $request)  // <-- Tambahkan Request $request
    {
        // Memulai query dasar
        $query = Transaksi::with(['menu'])  // kita tidak perlu 'delivery' di sini berdasarkan struktur terakhir
            ->where('email', Auth::user()->email);

        // [BARU] Terapkan filter jika ada
        if ($request->filled('jenis_pesanan') && in_array($request->jenis_pesanan, ['delivery', 'di_lokasi'])) {
            $query->where('jenis_pesanan', $request->jenis_pesanan);
        }

        // Ambil data dengan urutan dan pagination
        $transaksi = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();  // [BARU] agar filter tetap ada saat pindah halaman pagination

        return view('pages.users.transaksi', compact('transaksi'));
    }

    public function userDetail($kode_transaksi)
    {
        $transaksi = Transaksi::with('menu')
            ->where('kode_transaksi', $kode_transaksi)
            ->where('email', Auth::user()->email)
            ->firstOrFail();

        return view('pages.users.transaksi_detail', compact('transaksi'));
    }

    /**
     * Show form to create new transaction
     */
    public function userCreate()
    {
        $menus = Menu::where('status', 'aktif')->get();
        return view('user.transaksi.create', compact('menus'));
    }

    /**
     * Store new transaction from user
     */
    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_menu' => 'required|exists:menu,kode_menu',
            'jumlah'    => 'required|integer|min:1',
            'bukti_tf'  => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $menu        = Menu::where('kode_menu', $request->kode_menu)->first();
        $harga_total = $menu->harga * $request->jumlah;

        $bukti_tf_path = null;
        if ($request->hasFile('bukti_tf')) {
            $bukti_tf_path = $request
                ->file('bukti_tf')
                ->store('bukti_transfer', 'public');
        }

        $transaksi = Transaksi::create([
            'email'             => Auth::user()->email,
            'kode_menu'         => $request->kode_menu,
            'jumlah'            => $request->jumlah,
            'harga_total'       => $harga_total,
            'status'            => 'pending',
            'bukti_tf'          => $bukti_tf_path,
            'tanggal_transaksi' => now(),
        ]);

        return redirect()
            ->route('user.transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat! Silakan tunggu konfirmasi admin.');
    }

    /**
     * Show checkout form from cart
     */
    public function userCheckout()
    {
        $keranjang = Keranjang::where('email', Auth::user()->email)->first();

        if (!$keranjang) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Keranjang kosong. Silakan tambahkan menu terlebih dahulu.');
        }

        $cartItems = $keranjang->items()->with('menu')->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Keranjang kosong. Silakan tambahkan menu terlebih dahulu.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->menu->harga;
        });

        $pajak = $subtotal * 0.1;
        $total = $subtotal + $pajak;

        return view('user.transaksi.checkout', compact('cartItems', 'subtotal', 'pajak', 'total'));
    }

    public function userCheckoutStore(Request $request)
    {
        // 1. Validasi data request (dengan validasi kondisional)
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:dana,shopee_pay,cash',  // Validasi metode pembayaran
            'catatan'        => 'nullable|string|max:500',
            'jenis_pesanan'  => 'required|in:delivery,di_lokasi',
            // Jadikan bukti transfer wajib HANYA JIKA metode pembayaran bukan 'cash'
            'bukti_tf'       => [
                Rule::requiredIf(fn() => $request->input('payment_method') !== 'cash'),
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $keranjang = Keranjang::where('email', Auth::user()->email)->first();

            if (!$keranjang || $keranjang->items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang Anda kosong atau tidak ditemukan.'
                ], 400);
            }

            $cartItems = $keranjang->items()->with('menu')->get();

            // --- PERUBAHAN UTAMA DIMULAI DI SINI ---

            $bukti_tf_path = null;  // Deklarasikan sebagai null terlebih dahulu

            // 2. Proses upload file HANYA JIKA metode pembayaran BUKAN 'cash'
            if ($request->input('payment_method') !== 'cash') {
                if ($request->hasFile('bukti_tf')) {
                    $bukti_tf_path = $request->file('bukti_tf')->store('bukti_transfer', 'public');
                }
            }

            // --- PERUBAHAN UTAMA SELESAI ---

            // Loop untuk membuat transaksi per item
            foreach ($cartItems as $item) {
                $harga_item = $item->menu->harga * $item->quantity;

                // 3. Buat transaksi dengan path bukti transfer yang sudah diproses
                Transaksi::create([
                    'email'             => Auth::user()->email,
                    'kode_menu'         => $item->kode_menu,
                    'jumlah'            => $item->quantity,
                    'harga_total'       => $harga_item,
                    'status'            => 'pending',
                    'jenis_pesanan'     => $request->jenis_pesanan,
                    'bukti_tf'          => $bukti_tf_path,  // Akan berisi path atau null
                    'catatan'           => $request->catatan,
                    'payment_method'    => $request->payment_method,  // Simpan juga metode pembayarannya
                    'tanggal_transaksi' => now(),
                ]);
            }

            // Hapus item dari keranjang setelah checkout berhasil
            $keranjang->items()->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checkout berhasil! Transaksi Anda sedang diproses.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    /**
     * Show specific transaction detail for user
     */
    public function userShow($id)
    {
        $transaksi = Transaksi::with(['menu', 'delivery'])
            ->where('kode_transaksi', $id)
            ->where('email', Auth::user()->email)
            ->firstOrFail();

        return view('user.transaksi.show', compact('transaksi'));
    }

    /**
     * Cancel pending transaction
     */
    public function userCancel($id)
    {
        $transaksi = Transaksi::where('kode_transaksi', $id)
            ->where('email', Auth::user()->email)
            ->where('status', 'pending')
            ->firstOrFail();

        $transaksi->update(['status' => 'dibatalkan']);

        return redirect()
            ->route('user.transaksi.index')
            ->with('success', 'Transaksi berhasil dibatalkan.');
    }

    // ============= ADMIN FUNCTIONS =============

    /**
     * Display all transactions for admin
     */
    public function adminIndex(Request $request)
    {
        $query = Transaksi::with(['user', 'menu', 'delivery']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Tambahkan filter jenis pesanan
        if ($request->filled('jenis_pesanan')) {
            $query->where('jenis_pesanan', $request->jenis_pesanan);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('kode_transaksi', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $transaksi = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('pages.admin.transaksi.index', compact('transaksi'));
    }

    public function adminCreate()
    {
        $menus = \App\Models\Menu::all();
        $users = \App\Models\User::all();
        return view('pages.admin.transaksi.create', compact('menus', 'users'));
    }

    // [DIUBAH] Menambahkan validasi untuk 'jenis_pesanan'
    public function adminStore(Request $request)
    {
        $request->validate([
            'email'             => 'required|email|exists:users,email',
            'kode_menu'         => 'required|exists:menu,kode_menu',
            'jumlah'            => 'required|integer|min:1',
            'status'            => 'required|string',
            'jenis_pesanan'     => 'required|in:delivery,di_lokasi',  // [DIUBAH] Validasi baru
            'tanggal_transaksi' => 'required|date',
        ]);

        $menu                        = \App\Models\Menu::where('kode_menu', $request->kode_menu)->first();
        $harga_total                 = $menu->harga * $request->jumlah;
        $dataToCreate                = $request->all();
        $dataToCreate['harga_total'] = $harga_total;
        \App\Models\Transaksi::create($dataToCreate);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function adminShow($kode_transaksi)
    {
        $transaksi = \App\Models\Transaksi::with(['user', 'menu', 'delivery'])->where('kode_transaksi', $kode_transaksi)->firstOrFail();
        return view('pages.admin.transaksi.show', compact('transaksi'));
    }

    public function adminEdit($kode_transaksi)
    {
        $transaksi = \App\Models\Transaksi::where('kode_transaksi', $kode_transaksi)->firstOrFail();
        $menus     = \App\Models\Menu::all();
        $users     = \App\Models\User::all();
        return view('pages.admin.transaksi.edit', compact('transaksi', 'menus', 'users'));
    }

    // [DIUBAH] Menambahkan validasi untuk 'jenis_pesanan'

    public function adminUpdate(Request $request, $kode_transaksi)
    {
        // 1. Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'email'             => 'required|email|exists:users,email',
            'kode_menu'         => 'required|exists:menu,kode_menu',
            'jumlah'            => 'required|integer|min:1',
            'status'            => 'required|string',
            'tanggal_transaksi' => 'required|date',
            // 'jenis_pesanan' tidak lagi divalidasi di sini karena tidak ada di form edit
        ]);

        // 2. Cari transaksi dan menu yang relevan
        $transaksi = \App\Models\Transaksi::findOrFail($kode_transaksi);
        $menu      = \App\Models\Menu::findOrFail($request->kode_menu);

        // 3. Hitung ulang harga total berdasarkan input terbaru
        $validatedData['harga_total'] = $menu->harga * $request->jumlah;

        // 4. Update transaksi hanya dengan data yang sudah tervalidasi
        $transaksi->update($validatedData);

        // 5. Redirect dengan pesan sukses
        // [DIUBAH] Mengarahkan ke halaman detail untuk melihat perubahan
        return redirect()
            ->route('admin.transaksi.show', $transaksi->kode_transaksi)
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function adminDestroy($kode_transaksi)
    {
        $transaksi = \App\Models\Transaksi::where('kode_transaksi', $kode_transaksi)->firstOrFail();
        $transaksi->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Confirm pending transaction
     */
    public function adminConfirm($id)
    {
        $transaksi = Transaksi::where('kode_transaksi', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $transaksi->update(['status' => 'dikonfirmasi']);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Transaksi berhasil dikonfirmasi.');
    }

    /**
     * Reject pending transaction
     */
    public function adminReject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'alasan_penolakan' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        $transaksi = Transaksi::where('kode_transaksi', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $transaksi->update([
            'status'           => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Transaksi berhasil ditolak.');
    }

    // [BARU] Fungsi ini ditambahkan untuk menandai pesanan telah dikirim

    /**
     * Tandai transaksi sebagai telah dikirim (hanya untuk delivery)
     */
    public function adminMarkAsShipped($id)
    {
        $transaksi = Transaksi::where('kode_transaksi', $id)
            ->where('status', 'dikonfirmasi')
            ->where('jenis_pesanan', 'delivery')  // Pastikan hanya untuk delivery
            ->firstOrFail();

        $transaksi->update(['status' => 'dikirim']);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Transaksi berhasil ditandai sebagai "Dikirim".');
    }

    /**
     * Mark transaction as completed
     */
    public function adminComplete($id)
    {
        $transaksi = Transaksi::where('kode_transaksi', $id)
            ->whereIn('status', ['dikonfirmasi', 'dikirim'])
            ->firstOrFail();

        $transaksi->update(['status' => 'selesai']);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Transaksi berhasil diselesaikan.');
    }

    /**
     * Show transaction statistics for admin dashboard
     */
    public function adminStats()
    {
        $today     = now()->toDateString();
        $thisMonth = now()->startOfMonth();

        $stats = [
            'total_transaksi'      => Transaksi::count(),
            'transaksi_hari_ini'   => Transaksi::whereDate('tanggal_transaksi', $today)->count(),
            'transaksi_bulan_ini'  => Transaksi::where('created_at', '>=', $thisMonth)->count(),
            'pending'              => Transaksi::where('status', 'pending')->count(),
            'dikonfirmasi'         => Transaksi::where('status', 'dikonfirmasi')->count(),
            'selesai'              => Transaksi::where('status', 'selesai')->count(),
            'total_pendapatan'     => Transaksi::where('status', 'selesai')
                ->sum('harga_total'),
            'pendapatan_bulan_ini' => Transaksi::where('status', 'selesai')
                ->where('created_at', '>=', $thisMonth)
                ->sum('harga_total'),
        ];

        $recent_transaksi = Transaksi::with(['user', 'menu'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard.stats', compact('stats', 'recent_transaksi'));
    }

    /**
     * Export transactions to CSV
     */
    public function report(Request $request)
    {
        // Kueri awal untuk laporan transaksi dengan filter
        $query = Transaksi::with(['user', 'menu']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->tanggal_akhir);
        }

        // Mengambil data transaksi yang telah difilter dengan paginasi
        $transaksi = $query->orderBy('created_at', 'desc')->paginate(10);

        // --- Tambahan untuk Pengguna dengan Transaksi Terbanyak ---
        $userTerbanyakTransaksi = User::withCount('transaksi')
            ->orderBy('transaksi_count', 'desc')
            ->first();

        // --- Tambahan untuk Tiga Menu Terlaris ---
        $menuTerlaris = Menu::withCount(['transaksi as jumlah_terjual' => function ($query) {
            $query->select(DB::raw('sum(jumlah)'));
        }])
            ->orderBy('jumlah_terjual', 'desc')
            ->take(3)
            ->get();

        // Mengirim semua data ke view
        return view('pages.admin.transaksi.laporan', compact('transaksi', 'userTerbanyakTransaksi', 'menuTerlaris'));
    }

    public function adminExport(Request $request)
    {
        $query = Transaksi::with(['user', 'menu']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_transaksi', '<=', $request->tanggal_akhir);
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();
        $filename  = 'transaksi_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers   = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transaksi) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Kode Transaksi',
                'Email User',
                'Menu',
                'Jumlah',
                'Harga Total',
                'Status',
                'Tanggal Transaksi',
                'Dibuat Pada'
            ]);

            foreach ($transaksi as $t) {
                fputcsv($file, [
                    $t->kode_transaksi,
                    $t->email,
                    $t->menu->nama_menu ?? 'N/A',
                    $t->jumlah,
                    $t->harga_total,
                    $t->status,
                    $t->tanggal_transaksi->format('Y-m-d H:i:s'),
                    $t->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Update the status of a transaction
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,dikonfirmasi,selesai,dikirim,ditolak',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $transaksi = Transaksi::where('kode_transaksi', $id)->firstOrFail();
        $transaksi->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
