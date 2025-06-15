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
            ->where('email_222297', Auth::user()->email_222297);

        // [BARU] Terapkan filter jika ada
        if ($request->filled('jenis_pesanan') && in_array($request->jenis_pesanan, ['delivery', 'di_lokasi'])) {
            $query->where('jenis_pesanan_222297', $request->jenis_pesanan);
        }

        // Ambil data dengan urutan dan pagination
        $transaksi = $query
            ->orderBy('created_at_222297', 'desc')
            ->paginate(10)
            ->withQueryString();  // [BARU] agar filter tetap ada saat pindah halaman pagination

        return view('pages.users.transaksi', compact('transaksi'));
    }

    public function userDetail($kode_transaksi)
    {
        $transaksi = Transaksi::with('menu')
            ->where('kode_transaksi_222297', $kode_transaksi)
            ->where('email_222297', Auth::user()->email_222297)
            ->firstOrFail();

        return view('pages.users.transaksi_detail', compact('transaksi'));
    }

    /**
     * Show form to create new transaction
     */
    public function userCreate()
    {
        $menus = Menu::where('status_222297', 'aktif')->get();
        return view('user.transaksi.create', compact('menus'));
    }

    /**
     * Store new transaction from user
     */
    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_menu_222297' => 'required|exists:menu_222297,kode_menu_222297',
            'jumlah_222297'    => 'required|integer|min:1',
            'bukti_tf_222297'  => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $menu        = Menu::where('kode_menu_222297', $request->kode_menu_222297)->first();
        $harga_total = $menu->harga_222297 * $request->jumlah_222297;

        $bukti_tf_path = null;
        if ($request->hasFile('bukti_tf_222297')) {
            $bukti_tf_path = $request
                ->file('bukti_tf_222297')
                ->store('bukti_transfer', 'public');
        }

        $transaksi = Transaksi::create([
            'email_222297'             => Auth::user()->email_222297,
            'kode_menu_222297'         => $request->kode_menu_222297,
            'jumlah_222297'            => $request->jumlah_222297,
            'harga_total_222297'       => $harga_total,
            'status_222297'            => 'pending',
            'bukti_tf_222297'          => $bukti_tf_path,
            'tanggal_transaksi_222297' => now(),
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
        $keranjang = Keranjang::where('email_222297', Auth::user()->email_222297)->first();

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
            return $item->quantity_222297 * $item->menu->harga_222297;
        });

        $pajak = $subtotal * 0.1;
        $total = $subtotal + $pajak;

        return view('user.transaksi.checkout', compact('cartItems', 'subtotal', 'pajak', 'total'));
    }

    // [DIUBAH] Metode ini diubah untuk menerima dan memvalidasi 'jenis_pesanan_222297'
    public function userCheckoutStore(Request $request)
    {
        // 1. Validate the request data
        $validator = Validator::make($request->all(), [
            'bukti_tf_222297'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_222297'       => 'nullable|string|max:500',
            'jenis_pesanan_222297' => 'required|in:delivery,di_lokasi',  // [DIUBAH] Validasi untuk jenis pesanan
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

            $keranjang = Keranjang::where('email_222297', Auth::user()->email_222297)->first();

            if (!$keranjang || $keranjang->items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang Anda kosong atau tidak ditemukan.'
                ], 400);
            }

            $cartItems     = $keranjang->items()->with('menu')->get();
            $bukti_tf_path = $request->file('bukti_tf_222297')->store('bukti_transfer', 'public');

            foreach ($cartItems as $item) {
                $harga_item = $item->menu->harga_222297 * $item->quantity_222297;

                Transaksi::create([
                    'email_222297'             => Auth::user()->email_222297,
                    'kode_menu_222297'         => $item->kode_menu_222297,
                    'jumlah_222297'            => $item->quantity_222297,
                    'harga_total_222297'       => $harga_item,
                    'status_222297'            => 'pending',
                    'jenis_pesanan_222297'     => $request->jenis_pesanan_222297,  // [DIUBAH] Menyimpan jenis pesanan
                    'bukti_tf_222297'          => $bukti_tf_path,
                    'catatan_222297'           => $request->catatan_222297,
                    'tanggal_transaksi_222297' => now(),
                ]);
            }

            $keranjang->items()->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Checkout berhasil! Transaksi Anda sedang diproses.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
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
            ->where('kode_transaksi_222297', $id)
            ->where('email_222297', Auth::user()->email_222297)
            ->firstOrFail();

        return view('user.transaksi.show', compact('transaksi'));
    }

    /**
     * Cancel pending transaction
     */
    public function userCancel($id)
    {
        $transaksi = Transaksi::where('kode_transaksi_222297', $id)
            ->where('email_222297', Auth::user()->email_222297)
            ->where('status_222297', 'pending')
            ->firstOrFail();

        $transaksi->update(['status_222297' => 'dibatalkan']);

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
            $query->where('status_222297', $request->status);
        }

        // Tambahkan filter jenis pesanan
        if ($request->filled('jenis_pesanan')) {
            $query->where('jenis_pesanan_222297', $request->jenis_pesanan);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi_222297', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_transaksi_222297', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('kode_transaksi_222297', 'like', "%{$search}%")
                    ->orWhere('email_222297', 'like', "%{$search}%");
            });
        }

        $transaksi = $query->orderBy('created_at_222297', 'desc')->paginate(15);
        return view('pages.admin.transaksi.index', compact('transaksi'));
    }

    public function adminCreate()
    {
        $menus = \App\Models\Menu::all();
        $users = \App\Models\User::all();
        return view('pages.admin.transaksi.create', compact('menus', 'users'));
    }

    // [DIUBAH] Menambahkan validasi untuk 'jenis_pesanan_222297'
    public function adminStore(Request $request)
    {
        $request->validate([
            'email_222297'             => 'required|email|exists:users_222297,email_222297',
            'kode_menu_222297'         => 'required|exists:menu_222297,kode_menu_222297',
            'jumlah_222297'            => 'required|integer|min:1',
            'status_222297'            => 'required|string',
            'jenis_pesanan_222297'     => 'required|in:delivery,di_lokasi',  // [DIUBAH] Validasi baru
            'tanggal_transaksi_222297' => 'required|date',
        ]);

        $menu                               = \App\Models\Menu::where('kode_menu_222297', $request->kode_menu_222297)->first();
        $harga_total                        = $menu->harga_222297 * $request->jumlah_222297;
        $dataToCreate                       = $request->all();
        $dataToCreate['harga_total_222297'] = $harga_total;
        \App\Models\Transaksi::create($dataToCreate);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function adminShow($kode_transaksi)
    {
        $transaksi = \App\Models\Transaksi::with(['user', 'menu', 'delivery'])->where('kode_transaksi_222297', $kode_transaksi)->firstOrFail();
        return view('pages.admin.transaksi.show', compact('transaksi'));
    }

    public function adminEdit($kode_transaksi)
    {
        $transaksi = \App\Models\Transaksi::where('kode_transaksi_222297', $kode_transaksi)->firstOrFail();
        $menus     = \App\Models\Menu::all();
        $users     = \App\Models\User::all();
        return view('pages.admin.transaksi.edit', compact('transaksi', 'menus', 'users'));
    }

    // [DIUBAH] Menambahkan validasi untuk 'jenis_pesanan_222297'
    public function adminUpdate(Request $request, $kode_transaksi)
    {
        $request->validate([
            'email_222297'             => 'required|email|exists:users_222297,email_222297',
            'kode_menu_222297'         => 'required|exists:menu_222297,kode_menu_222297',
            'jumlah_222297'            => 'required|integer|min:1',
            'status_222297'            => 'required|string',
            'jenis_pesanan_222297'     => 'required|in:delivery,di_lokasi',  // [DIUBAH] Validasi baru
            'tanggal_transaksi_222297' => 'required|date',
        ]);

        $transaksi                          = \App\Models\Transaksi::where('kode_transaksi_222297', $kode_transaksi)->firstOrFail();
        $menu                               = \App\Models\Menu::where('kode_menu_222297', $request->kode_menu_222297)->first();
        $dataToUpdate                       = $request->all();
        $dataToUpdate['harga_total_222297'] = $menu->harga_222297 * $request->jumlah_222297;
        $transaksi->update($dataToUpdate);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function adminDestroy($kode_transaksi)
    {
        $transaksi = \App\Models\Transaksi::where('kode_transaksi_222297', $kode_transaksi)->firstOrFail();
        $transaksi->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Confirm pending transaction
     */
    public function adminConfirm($id)
    {
        $transaksi = Transaksi::where('kode_transaksi_222297', $id)
            ->where('status_222297', 'pending')
            ->firstOrFail();

        $transaksi->update(['status_222297' => 'dikonfirmasi']);

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

        $transaksi = Transaksi::where('kode_transaksi_222297', $id)
            ->where('status_222297', 'pending')
            ->firstOrFail();

        $transaksi->update([
            'status_222297'           => 'ditolak',
            'alasan_penolakan_222297' => $request->alasan_penolakan
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
        $transaksi = Transaksi::where('kode_transaksi_222297', $id)
            ->where('status_222297', 'dikonfirmasi')
            ->where('jenis_pesanan_222297', 'delivery')  // Pastikan hanya untuk delivery
            ->firstOrFail();

        $transaksi->update(['status_222297' => 'dikirim']);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Transaksi berhasil ditandai sebagai "Dikirim".');
    }

    /**
     * Mark transaction as completed
     */
    public function adminComplete($id)
    {
        $transaksi = Transaksi::where('kode_transaksi_222297', $id)
            ->whereIn('status_222297', ['dikonfirmasi', 'dikirim'])
            ->firstOrFail();

        $transaksi->update(['status_222297' => 'selesai']);

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
            'transaksi_hari_ini'   => Transaksi::whereDate('tanggal_transaksi_222297', $today)->count(),
            'transaksi_bulan_ini'  => Transaksi::where('created_at_222297', '>=', $thisMonth)->count(),
            'pending'              => Transaksi::where('status_222297', 'pending')->count(),
            'dikonfirmasi'         => Transaksi::where('status_222297', 'dikonfirmasi')->count(),
            'selesai'              => Transaksi::where('status_222297', 'selesai')->count(),
            'total_pendapatan'     => Transaksi::where('status_222297', 'selesai')
                ->sum('harga_total_222297'),
            'pendapatan_bulan_ini' => Transaksi::where('status_222297', 'selesai')
                ->where('created_at_222297', '>=', $thisMonth)
                ->sum('harga_total_222297'),
        ];

        $recent_transaksi = Transaksi::with(['user', 'menu'])
            ->orderBy('created_at_222297', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard.stats', compact('stats', 'recent_transaksi'));
    }

    /**
     * Export transactions to CSV
     */
    public function report(Request $request)
    {
        $query = Transaksi::with(['user', 'menu']);

        if ($request->filled('status')) {
            $query->where('status_222297', $request->status);
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi_222297', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_transaksi_222297', '<=', $request->tanggal_akhir);
        }

        $transaksi = $query->orderBy('created_at_222297', 'desc')->paginate(10);
        return view('pages.admin.transaksi.laporan', compact('transaksi'));
    }

    public function adminExport(Request $request)
    {
        $query = Transaksi::with(['user', 'menu']);

        if ($request->filled('status')) {
            $query->where('status_222297', $request->status);
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi_222297', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_transaksi_222297', '<=', $request->tanggal_akhir);
        }

        $transaksi = $query->orderBy('created_at_222297', 'desc')->get();
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
                    $t->kode_transaksi_222297,
                    $t->email_222297,
                    $t->menu->nama_menu_222297 ?? 'N/A',
                    $t->jumlah_222297,
                    $t->harga_total_222297,
                    $t->status_222297,
                    $t->tanggal_transaksi_222297->format('Y-m-d H:i:s'),
                    $t->created_at_222297->format('Y-m-d H:i:s')
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
            'status_222297' => 'required|in:pending,dikonfirmasi,selesai,dikirim,ditolak',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $transaksi = Transaksi::where('kode_transaksi_222297', $id)->firstOrFail();
        $transaksi->update([
            'status_222297' => $request->status_222297,
        ]);

        return redirect()
            ->route('admin.transaksi.show', $id)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
