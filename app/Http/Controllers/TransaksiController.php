<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Services\CheckoutService;
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

    public function handleWebhook(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        // Validasi Signature Key
        $expectedSignature = hash("sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($expectedSignature !== $request->signature_key) {
            Log::warning("Invalid Midtrans signature", $request->all());
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transaction = Transaksi::where('order_id_midtrans', $request->order_id)->first();

        if (! $transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $statusMap = [
            'settlement' => 'paid',
            'capture'    => 'paid',
            'pending'    => 'pending',
            'cancel'     => 'failed',
            'expire'     => 'failed',
            'deny'       => 'failed',
        ];

        $midtransStatus = $request->transaction_status;
        if (isset($statusMap[$midtransStatus])) {
            $transaction->status = $statusMap[$midtransStatus];
            $transaction->save();
        }

        Log::info("Webhook processed for Order {$request->order_id} - Status: {$midtransStatus}");

        return response()->json(['message' => 'Webhook processed successfully']);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status'   => 'required|string|in:pending,paid,failed,cancelled',
        ]);

        try {
            $transaksi = $this->checkoutService->updateStatus(
                $request->order_id,
                $request->status
            );

            return response()->json([
                'success'   => true,
                'message'   => 'Status transaksi berhasil diupdate.',
                'transaksi' => $transaksi,
            ]);

        } catch (\Exception $e) {
            Log::error("Gagal update status transaksi: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function index()
    {
        $transaksis = $this->checkoutService->getUserTransactions(Auth::user());

        return Inertia::render('Users/Transaksi', [
            'transaksis' => $transaksis,
        ]);
    }

    public function indexAdmin()
    {
        $transaksis = $this->checkoutService->getAllTransactions()->items();

        return Inertia::render('Admin/Transaksi', [
            'transaksis' => $transaksis,
        ]);
    }

    public function show($kode_transaksi)
    {
        try {
            $transaksi = $this->checkoutService->getTransactionDetails($kode_transaksi, Auth::user());

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