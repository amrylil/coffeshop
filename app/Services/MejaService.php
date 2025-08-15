<?php
namespace App\Services;

use App\Models\Meja;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class MejaService
 * @package App\Services
 */
class MejaService
{
    /**
     * Mengambil semua data meja.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Meja::all();
    }

    /**
     * Mencari meja berdasarkan ID.
     *
     * @param int|string $id
     * @return Meja
     */
    public function findById($id): Meja
    {
        return Meja::findOrFail($id);
    }

    /**
     * Membuat data meja baru.
     *
     * @param array $data Data yang sudah divalidasi
     * @return Meja
     * @throws Exception
     */
    public function create(array $data): Meja
    {
        DB::beginTransaction();
        try {
            $meja = Meja::create($data);
            DB::commit();
            return $meja;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat meja: ' . $e->getMessage());
            throw new Exception('Gagal menyimpan data meja.');
        }
    }

    /**
     * Memperbarui data meja yang ada.
     *
     * @param Meja $meja Model meja yang akan diupdate
     * @param array $data Data baru dari request
     * @return Meja
     * @throws Exception
     */
    public function update(Meja $meja, array $data): Meja
    {
        DB::beginTransaction();
        try {
            $meja->update($data);
            DB::commit();
            return $meja;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal memperbarui meja {$meja->getKey()}: " . $e->getMessage());
            throw new Exception('Gagal memperbarui data meja.');
        }
    }

    /**
     * Menghapus data meja.
     *
     * @param Meja $meja Model meja yang akan dihapus
     * @return bool
     * @throws Exception
     */
    public function delete(Meja $meja): bool
    {
        DB::beginTransaction();
        try {
            $meja->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal menghapus meja {$meja->getKey()}: " . $e->getMessage());
            throw new Exception('Gagal menghapus data meja.');
        }
    }

    /**
     * Memperbarui status meja dan mengembalikan pesan sukses.
     *
     * @param Meja $meja
     * @param string $newStatus
     * @return string Pesan sukses untuk ditampilkan
     * @throws Exception
     */
    public function updateStatus(Meja $meja, string $newStatus): string
    {
        DB::beginTransaction();
        try {
            $oldStatus = $meja->status_222297;

            $meja->update(['status_222297' => $newStatus]);

            DB::commit();

            $statusLabels = [
                'kosong'    => 'Kosong',
                'dipesan'   => 'Dipesan',
                'digunakan' => 'Digunakan',
            ];

            // Membuat pesan dinamis berdasarkan perubahan status
            return "Meja {$meja->nomor_meja_222297} status berubah dari {$statusLabels[$oldStatus]} ke {$statusLabels[$newStatus]}";

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal memperbarui status meja {$meja->getKey()}: " . $e->getMessage());
            throw new Exception('Gagal mengupdate status meja. Silakan coba lagi.');
        }
    }
}