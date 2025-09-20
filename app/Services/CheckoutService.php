<?php
namespace App\Services;

use App\Models\ItemTransaksi;
use App\Models\Transaksi;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutService
{

    public function processCheckout(array $data): array
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');

        DB::beginTransaction();

        try {
            $transaksi = Transaksi::create([
                'user_id'     => $data['user']->id,
                'total_harga' => $data['total_harga'],
                'status'      => 'pending',
                'catatan'     => $data['catatan'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                ItemTransaksi::create([
                    'transaksi_id' => $transaksi->kode_transaksi,
                    'kode_menu'    => $item['kode_menu'],
                    'jumlah'       => $item['jumlah'],
                    'harga'        => $item['harga'],
                ]);
            }

            $orderId = $transaksi->kode_transaksi;
            $params  = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $transaksi->total_harga,
                ],
                'customer_details'    => [
                    'first_name' => $data['user']->name,
                    'email'      => $data['user']->email,
                    'phone'      => $data['user']->phone ?? '',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            $transaksi->update(['order_id_midtrans' => $orderId]);

            DB::commit();

            return [
                'transaksi'  => $transaksi,
                'snap_token' => $snapToken,
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal memproses checkout: ' . $e->getMessage() . ' on line ' . $e->getLine());
            throw new Exception('Gagal memproses pembayaran Anda. Silakan coba beberapa saat lagi.');
        }
    }

    public function createCashTransaction(array $data, User $cashier): Transaksi
    {
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'user_id'          => $cashier->id,
                'total_harga'      => $data['total_harga'],
                'status'           => 'lunas',
                'jenis_pembayaran' => 'tunai',
                'catatan'          => $data['catatan'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                ItemTransaksi::create([
                    'transaksi_id' => $transaksi->kode_transaksi,
                    'kode_menu'    => $item['kode_menu'],
                    'jumlah'       => $item['jumlah'],
                    'harga'        => $item['harga'],
                ]);

            }

            DB::commit();

            return $transaksi;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat transaksi tunai: ' . $e->getMessage());
            throw new Exception('Gagal menyimpan transaksi. Silakan coba lagi.');
        }
    }

    public function updateStatus(string $orderId, string $status): Transaksi
    {
        $transaksi = Transaksi::where('order_id_midtrans', $orderId)
            ->first();

        if (! $transaksi) {
            throw new Exception("Transaksi dengan order_id {$orderId} tidak ditemukan.");
        }

        $transaksi->status = $status;
        $transaksi->save();

        Log::info("Status transaksi {$orderId} diupdate menjadi {$status}");

        return $transaksi;
    }
    public function getUserTransactions(User $user): LengthAwarePaginator
    {
        return Transaksi::where('user_id', $user->id)
            ->with('items.menu')
            ->latest()
            ->paginate(10);
    }

    /**
     * [ADMIN] Mengambil semua transaksi dari semua pengguna dengan paginasi.
     *
     * @return LengthAwarePaginator
     */
    public function getAllTransactions(): LengthAwarePaginator
    {
        $data = Transaksi::with(['pengguna', 'items.menu'])
            ->latest()
            ->paginate(15);

        return $data;
    }

    /**
     * Mengambil detail satu transaksi spesifik dengan pengecekan hak akses.
     *
     * @param string $kode_transaksi
     * @param User $user
     * @return Transaksi
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getTransactionDetails(string $kode_transaksi, User $user): Transaksi
    {
        $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)
            ->with(['pengguna', 'items.menu'])
            ->firstOrFail();

        // Pengecekan hak akses: user hanya boleh lihat transaksinya sendiri, kecuali jika dia admin.
        if (! $user->isAdmin() && $transaksi->user_id !== $user->id) {
            throw new AuthorizationException('Akses ditolak.');
        }

        return $transaksi;
    }
}