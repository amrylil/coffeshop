<?php
namespace App\Services;

use App\Models\Inventory;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class InventoryService
 * @package App\Services
 */
class InventoryService
{
    /**
     * Mengambil semua data inventaris.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Inventory::orderBy('nama_bahan')->get();
    }

    /**
     * Mencari data inventaris berdasarkan primary key (kode_bahan).
     *
     * @param string $kode_bahan
     * @return Inventory
     */
    public function findById(string $kode_bahan): Inventory
    {
        return Inventory::findOrFail($kode_bahan);
    }

    /**
     * Membuat data inventaris baru.
     *
     * @param array $data Data yang sudah divalidasi
     * @return Inventory
     * @throws Exception
     */
    public function create(array $data): Inventory
    {
        DB::beginTransaction();
        try {
            $inventory = Inventory::create($data);
            DB::commit();
            return $inventory;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat data inventaris: ' . $e->getMessage());
            throw new Exception('Gagal menyimpan data inventaris.');
        }
    }

    /**
     * Memperbarui data inventaris yang ada.
     *
     * @param Inventory $inventory Model inventaris yang akan diupdate
     * @param array $data Data baru dari request
     * @return Inventory
     * @throws Exception
     */
    public function update(Inventory $inventory, array $data): Inventory
    {
        DB::beginTransaction();
        try {
            $inventory->update($data);
            DB::commit();
            return $inventory;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal memperbarui inventaris {$inventory->getKey()}: " . $e->getMessage());
            throw new Exception('Gagal memperbarui data inventaris.');
        }
    }

    /**
     * Menghapus data inventaris.
     *
     * @param Inventory $inventory Model inventaris yang akan dihapus
     * @return bool
     * @throws Exception
     */
    public function delete(Inventory $inventory): bool
    {
        DB::beginTransaction();
        try {
            // Cek relasi sebelum menghapus jika diperlukan
            if ($inventory->menus()->exists()) {
                throw new Exception('Tidak dapat menghapus bahan yang masih terikat pada menu.');
            }

            $inventory->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal menghapus inventaris {$inventory->getKey()}: " . $e->getMessage());
            // Mengirimkan pesan error yang lebih spesifik jika berasal dari validasi relasi
            if ($e->getMessage() === 'Tidak dapat menghapus bahan yang masih terikat pada menu.') {
                throw $e;
            }
            throw new Exception('Gagal menghapus data inventaris.');
        }
    }
}