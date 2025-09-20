<?php
namespace App\Http\Controllers;

use App\Models\Menu; // <-- TAMBAHKAN
use App\Services\CheckoutService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CashierController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * Menampilkan halaman utama kasir (daftar transaksi).
     */
    public function index(): Response
    {
        // Ambil semua transaksi dan menu yang tersedia
        $transaksis = $this->checkoutService->getAllTransactions();
        $menus      = Menu::where('status', 'available')->get();
        return Inertia::render('Admin/Transaksi', [
            'transaksis' => $transaksis,
            'menus'      => $menus,
        ]);
    }

    /**
     * Menyimpan transaksi tunai baru yang dibuat oleh kasir.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'items'             => 'required|array|min:1',
            'items.*.kode_menu' => 'required|exists:menu,kode_menu',
            'items.*.jumlah'    => 'required|integer|min:1',
            'items.*.harga'     => 'required|numeric|min:0',
            'total_harga'       => 'required|numeric|min:0',
            'catatan'           => 'nullable|string|max:255',
        ]);

        try {
            $cashier = Auth::user();
            $this->checkoutService->createCashTransaction($validatedData, $cashier);

            return redirect()->route('admin.cashier.index')
                ->with('success', 'Transaksi tunai berhasil disimpan.');

        } catch (Exception $e) {
            Log::error('Error pada proses transaksi tunai: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Menampilkan detail transaksi (digunakan bersama oleh admin & kasir).
     */
    public function show($kode_transaksi)
    {
        // Memanfaatkan method yang sama dari TransaksiController
        $transaksiController = app(TransaksiController::class);
        return $transaksiController->show($kode_transaksi);
    }
}