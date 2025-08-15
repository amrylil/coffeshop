<?php
namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProfileService
 * @package App\Services
 */
class ProfileService
{
    /**
     * Memperbarui profil pengguna dengan data yang diberikan.
     *
     * @param User $user Pengguna yang akan diupdate
     * @param array $validatedData Data yang sudah divalidasi dari controller
     * @param \Illuminate\Http\UploadedFile|null $photoFile File foto profil baru
     * @return User
     * @throws Exception
     */
    public function update(User $user, array $validatedData, $photoFile = null): User
    {
        DB::beginTransaction();
        try {
            Log::info('Memulai proses update profil untuk user: ' . $user->id);

            // Jika ada password baru, hash dan tambahkan ke data
            if (! empty($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
                Log::info('Password baru untuk user ' . $user->id . ' telah di-hash.');
            } else {
                // Hapus key password jika kosong agar tidak menimpa password lama
                unset($validatedData['password']);
            }

            // Jika ada file foto baru yang diunggah
            if ($photoFile) {
                Log::info('File foto baru terdeteksi untuk user ' . $user->id);

                // Hapus foto lama jika ada
                if ($user->profile_photo) {
                    Log::info('Menghapus foto profil lama: ' . $user->profile_photo);
                    Storage::disk('public')->delete($user->profile_photo);
                }

                // Simpan foto baru dan dapatkan path-nya
                $path                           = $photoFile->store('profile_photos', 'public');
                $validatedData['profile_photo'] = $path;
                Log::info('Foto profil baru disimpan di: ' . $path);
            }

            // Update data pengguna
            $user->update($validatedData);
            Log::info('Update data ke database untuk user ' . $user->id . ' berhasil.');

            DB::commit();
            return $user;

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui profil user ' . $user->id . ': ' . $e->getMessage());
            throw new Exception('Gagal memperbarui profil.');
        }
    }
}