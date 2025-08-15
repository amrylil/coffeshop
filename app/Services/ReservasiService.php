<?php
namespace App\Services;

use App\Models\Reservasi;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ReservasiService
 * @package App\Services
 */
class ReservasiService
{
    /**
     * Mengambil semua data reservasi dengan paginasi dan relasi.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        // Mengambil data dengan relasi user dan meja, diurutkan berdasarkan yang terbaru
        return Reservasi::with(['user', 'meja'])->latest()->paginate(10);
    }

    /**
     * Membuat reservasi baru berdasarkan data yang valid.
     *
     * @param array $data Data dari request yang sudah divalidasi
     * @return Reservasi
     * @throws Exception
     */
    public function create(array $data): Reservasi
    {
        // Pengecekan apakah meja sudah direservasi pada tanggal dan jam yang sama
        $existingReservation = Reservasi::where('nomor_meja', $data['nomor_meja'])
            ->where('tanggal_reservasi', $data['tanggal_reservasi'])
            ->where('jam_reservasi', $data['jam_reservasi'])
            ->where('status', '!=', 'cancelled') // Abaikan reservasi yang dibatalkan
            ->first();

        if ($existingReservation) {
            // Jika sudah ada, lemparkan exception agar tidak terjadi double booking
            throw new Exception('Meja tidak tersedia pada tanggal dan jam yang dipilih.');
        }

        DB::beginTransaction();
        try {
            // Menetapkan status default 'pending' jika tidak ada
            if (! isset($data['status'])) {
                $data['status'] = 'pending';
            }

            $reservasi = Reservasi::create($data);

            DB::commit();
            return $reservasi;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat reservasi: ' . $e->getMessage());
            // Lemparkan exception untuk ditangani oleh controller
            throw new Exception('Gagal menyimpan data reservasi. ' . $e->getMessage());
        }
    }
    /**
     * Memperbarui data reservasi yang ada.
     *
     * @param Reservasi $reservasi Model reservasi yang akan diupdate
     * @param array $data Data baru dari request
     * @return Reservasi
     * @throws Exception
     */
    public function update(Reservasi $reservasi, array $data): Reservasi
    {
        DB::beginTransaction();
        try {
            $reservasi->update($data);

            DB::commit();
            return $reservasi;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal memperbarui reservasi {$reservasi->kode_reservasi}: " . $e->getMessage());
            throw new Exception('Gagal memperbarui data reservasi.');
        }
    }

    /**
     * Memperbarui status dari sebuah reservasi.
     *
     * @param Reservasi $reservasi Model reservasi
     * @param string $status Status baru (e.g., 'confirmed', 'cancelled', 'completed')
     * @return Reservasi
     * @throws Exception
     */
    public function updateStatus(Reservasi $reservasi, string $status): Reservasi
    {
        DB::beginTransaction();
        try {
            $reservasi->update(['status' => $status]);

            DB::commit();
            return $reservasi;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal memperbarui status reservasi {$reservasi->kode_reservasi}: " . $e->getMessage());
            throw new Exception('Gagal memperbarui status reservasi.');
        }
    }

    /**
     * Menghapus data reservasi.
     *
     * @param Reservasi $reservasi Model reservasi yang akan dihapus
     * @return bool
     * @throws Exception
     */
    public function delete(Reservasi $reservasi): bool
    {
        DB::beginTransaction();
        try {
            $reservasi->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal menghapus reservasi {$reservasi->kode_reservasi}: " . $e->getMessage());
            throw new Exception('Gagal menghapus data reservasi.');
        }
    }
}