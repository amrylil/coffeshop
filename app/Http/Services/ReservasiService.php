<?php
namespace App\Http\Services;

use App\Models\Meja;
use App\Models\Reservasi;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservasiService
{
    /**
     * Mengambil semua data meja.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllMeja()
    {
        return Meja::all();
    }

    /**
     * Mengambil daftar reservasi untuk halaman admin dengan paginasi.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAdminReservations(int $perPage = 15)
    {
        return Reservasi::with('meja')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Mengambil riwayat reservasi untuk pengguna yang sedang login.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserHistory(int $perPage = 10)
    {
        return Reservasi::where('email', Auth::user()->email)
            ->with('meja')
            ->latest('created_at')
            ->paginate($perPage);
    }

    /**
     * Mendapatkan detail reservasi berdasarkan kode.
     *
     * @param string $kode_reservasi
     * @return \App\Models\Reservasi
     */
    public function getReservationByCode(string $kode_reservasi): Reservasi
    {
        return Reservasi::with('meja')->findOrFail($kode_reservasi);
    }

    /**
     * Membuat reservasi baru dari sisi admin.
     *
     * @param array $data
     * @return \App\Models\Reservasi
     */
    public function createAdminReservation(array $data): Reservasi
    {
        $meja                 = Meja::where('nomor_meja', $data['nomor_meja'])->firstOrFail();
        $data['jumlah_orang'] = $meja->kapasitas;

        DB::beginTransaction();
        try {
            $reservasi = Reservasi::create($data);
            $meja->update(['status' => 'Dipesan']);
            DB::commit();
            return $reservasi;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat reservasi admin: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Membuat reservasi baru dari sisi pengguna.
     *
     * @param array $data
     * @return \App\Models\Reservasi
     */
    public function createUserReservation(array $data): Reservasi
    {
        $meja                 = Meja::where('nomor_meja', $data['nomor_meja'])->firstOrFail();
        $data['email']        = Auth::user()->email;
        $data['jumlah_orang'] = $meja->kapasitas;

        DB::beginTransaction();
        try {
            $reservasi = Reservasi::create($data);
            $meja->update(['status' => 'Dipesan']);
            DB::commit();
            return $reservasi;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat reservasi pengguna: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Memperbarui data reservasi dari sisi admin.
     *
     * @param string $kode_reservasi
     * @param array $data
     * @return \App\Models\Reservasi
     */
    public function updateAdminReservation(string $kode_reservasi, array $data): Reservasi
    {
        $reservasi            = Reservasi::findOrFail($kode_reservasi);
        $meja                 = Meja::where('nomor_meja', $data['nomor_meja'])->firstOrFail();
        $data['jumlah_orang'] = $meja->kapasitas;

        $reservasi->update($data);
        return $reservasi;
    }

    /**
     * Memperbarui data reservasi dari sisi pengguna (API).
     *
     * @param Reservasi $reservasi
     * @param array $data
     * @return Reservasi
     */
    public function updateUserReservation(Reservasi $reservasi, array $data): Reservasi
    {
        $reservasi->update($data);
        return $reservasi->load('meja');
    }

    /**
     * Menghapus reservasi dan memperbarui status meja jika perlu.
     *
     * @param string $kode_reservasi
     * @return void
     */
    public function deleteReservation(string $kode_reservasi): void
    {
        DB::beginTransaction();
        try {
            $reservasi = Reservasi::findOrFail($kode_reservasi);
            $meja      = $reservasi->meja;
            $reservasi->delete();

            // Cek apakah ada reservasi lain yang aktif untuk meja ini
            $adaReservasiLain = Reservasi::where('nomor_meja', $meja->nomor_meja)
                ->where('tanggal_reservasi', '>=', Carbon::today()->toDateString())
                ->exists();

            if (! $adaReservasiLain) {
                $meja->update(['status' => 'Tersedia']);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus reservasi: ' . $e->getMessage());
            throw $e;
        }
    }
}