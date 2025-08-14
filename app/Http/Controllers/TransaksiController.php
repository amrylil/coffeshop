<?php
namespace App\Http\Controllers;

use App\Http\Services\CheckoutService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

// <-- JANGAN LUPA DITAMBAHKAN

class TransaksiController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items'             => 'required|array',
            'items.*.kode_menu' => 'required|exists:menu,kode_menu',
            'items.*.jumlah'    => 'required|integer|min:1',
            'items.*.harga'     => 'required|numeric|min:0',
            'total_harga'       => 'required|numeric|min:0',
            'catatan'           => 'nullable|string',
        ]);

        try {
            $data = [
                'user'        => Auth::user(),
                'items'       => $request->input('items'),
                'total_harga' => $request->input('total_harga'),
                'catatan'     => $request->input('catatan'),
            ];

            $result = $this->checkoutService->processCheckout($data);

            return response()->json([
                'status'     => 'success',
                'snap_token' => $result['snap_token'],
                'transaksi'  => $result['transaksi'],
            ]);

        } catch (Exception $e) {
            Log::error('Error pada proses checkout: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $transaksis = $this->checkoutService->getUserTransactions(Auth::user());

        return Inertia::render('Transaksi/Index', [
            'transaksis' => $transaksis,
        ]);
    }

    public function indexAdmin()
    {
        $transaksis = $this->checkoutService->getAllTransactions();

        // --- PERBAIKAN ---
        // Sesuaikan nama komponen dengan struktur folder Anda, misal 'Admin/Transaksi/Index'
        return Inertia::render('Admin/Transaksi/Index', [
            'transaksis' => $transaksis,
        ]);
    }

    public function show($kode_transaksi)
    {
        try {
            $transaksi = $this->checkoutService->getTransactionDetails($kode_transaksi, Auth::user());

            // --- PERBAIKAN ---
            // Render komponen 'Transaksi/Show' dengan data detail transaksi.
            return Inertia::render('Transaksi/Show', [
                'transaksi' => $transaksi,
            ]);

        } catch (ModelNotFoundException $e) {
            // Respons error ini sudah benar, Inertia akan menanganinya.
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        } catch (AuthorizationException $e) {
            // Respons error ini sudah benar, Inertia akan menanganinya.
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            Log::error("Gagal mengambil detail transaksi: " . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan pada server.'], 500);
        }
    }
}