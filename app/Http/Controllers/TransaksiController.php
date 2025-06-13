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
    public function userIndex()
    {
        $transaksi = Transaksi::with(['menu', 'delivery'])
            ->where('email_222297', Auth::user()->email_222297)
            ->orderBy('created_at_222297', 'desc')
            ->paginate(10);

        return view('pages.users.transaksi', compact('transaksi'));
    }

    public function userDetail($kode_transaksi)
    {
        // Ambil data transaksi, pastikan hanya milik user yang login
        $transaksi = Transaksi::with('menu')
            ->where('kode_transaksi_222297', $kode_transaksi)
            ->where('email_222297', Auth::user()->email_222297)
            ->firstOrFail();  // Akan menampilkan error 404 jika tidak ditemukan

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

        // Upload bukti transfer
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
        // Get user's cart with all items and their menus
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

    public function userCheckoutStore(Request $request)
    {
        // 1. Validate the request data
        $validator = Validator::make($request->all(), [
            'bukti_tf_222297' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_222297'  => 'nullable|string|max:500'
        ]);

        // If validation fails, return a JSON response with the errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);  // 422 Unprocessable Entity
        }

        // 2. Wrap the entire operation in a database transaction
        try {
            // Start the transaction
            DB::beginTransaction();

            $keranjang = Keranjang::where('email_222297', Auth::user()->email_222297)->first();

            // Check if cart or items are empty
            if (!$keranjang || $keranjang->items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang Anda kosong atau tidak ditemukan.'
                ], 400);  // 400 Bad Request
            }

            $cartItems = $keranjang->items()->with('menu')->get();

            // 3. Handle the file upload
            $bukti_tf_path = $request->file('bukti_tf_222297')->store('bukti_transfer', 'public');

            // 4. Create transactions for each item
            foreach ($cartItems as $item) {
                $harga_item = $item->menu->harga_222297 * $item->quantity_222297;

                Transaksi::create([
                    'email_222297'             => Auth::user()->email_222297,
                    'kode_menu_222297'         => $item->kode_menu_222297,
                    'jumlah_222297'            => $item->quantity_222297,
                    'harga_total_222297'       => $harga_item,
                    'status_222297'            => 'pending',
                    'bukti_tf_222297'          => $bukti_tf_path,
                    'catatan_222297'           => $request->catatan_222297,
                    'tanggal_transaksi_222297' => now(),
                ]);
            }

            // 5. Clear the cart after successful checkout
            $keranjang->items()->delete();
            // It might be better to just clear items instead of deleting the cart itself
            // $keranjang->delete();

            // If everything is successful, commit the transaction
            DB::commit();

            // 6. Return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Checkout berhasil! Transaksi Anda sedang diproses.'
            ]);
        } catch (\Exception $e) {
            // If any error occurs, roll back the transaction
            DB::rollBack();

            // Log the error for debugging purposes
            Log::error('Checkout Error: ' . $e->getMessage());

            // Return a generic server error JSON response
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.'
            ], 500);  // 500 Internal Server Error
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

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_222297', $request->status);
        }

        // Filter by date range
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_transaksi_222297', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_transaksi_222297', '<=', $request->tanggal_akhir);
        }

        // Search by transaction code or user email
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

    public function adminStore(Request $request)
    {
        $request->validate([
            'email_222297'             => 'required|email|exists:users_222297,email_222297',
            'kode_menu_222297'         => 'required|exists:menu_222297,kode_menu_222297',
            'jumlah_222297'            => 'required|integer|min:1',
            'status_222297'            => 'required|string',
            'tanggal_transaksi_222297' => 'required|date',
        ]);

        $menu        = \App\Models\Menu::where('kode_menu_222297', $request->kode_menu_222297)->first();
        $harga_total = $menu->harga_222297 * $request->jumlah_222297;

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

    public function adminUpdate(Request $request, $kode_transaksi)
    {
        $request->validate([
            'email_222297'             => 'required|email|exists:users_222297,email_222297',
            'kode_menu_222297'         => 'required|exists:menu_222297,kode_menu_222297',
            'jumlah_222297'            => 'required|integer|min:1',
            'status_222297'            => 'required|string',
            'tanggal_transaksi_222297' => 'required|date',
        ]);

        $transaksi = \App\Models\Transaksi::where('kode_transaksi_222297', $kode_transaksi)->firstOrFail();
        $menu      = \App\Models\Menu::where('kode_menu_222297', $request->kode_menu_222297)->first();

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

    /** Show specific transaction detail for admin */
    // Removed duplicate adminShow method below to fix redeclaration error

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

        // Recent transactions
        $recent_transaksi = Transaksi::with(['user', 'menu'])
            ->orderBy('created_at_222297', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard.stats', compact('stats', 'recent_transaksi'));
    }

    /**
     * Export transactions to CSV
     */
    public function adminExport(Request $request)
    {
        $query = Transaksi::with(['user', 'menu']);

        // Apply same filters as index
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

        $filename = 'transaksi_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transaksi) {
            $file = fopen('php://output', 'w');

            // CSV Headers
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

            // CSV Data
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
}
