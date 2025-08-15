<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthService
{

    public function registerUser(array $data): User
    {
        // Handle profile photo upload
        $profilePhotoPath = null;
        if (isset($data['profile_photo'])) {
            $file = $data['profile_photo'];
            // Simpan file dan dapatkan path-nya. 'public' disk.
            $profilePhotoPath = $file->store('profile_photos', 'public');
        }

        // Create user
        return User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'gender'        => $data['gender'] ?? null,
            'address'       => $data['address'] ?? null,
            'phone'         => $data['phone'] ?? null,
            'birth_date'    => $data['birth_date'] ?? null,
            'profile_photo' => $profilePhotoPath,
            'role'          => 'customer',
        ]);
    }

    public function updateUserProfile(User $user, array $data): bool
    {
        if (isset($data['profile_photo'])) {
            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            // Simpan foto baru
            $data['profile_photo'] = $data['profile_photo']->store('profile_photos', 'public');
        }

        return $user->update($data);
    }

    public function changeUserPassword(User $user, array $data): bool
    {
        // Cek apakah password saat ini benar
        if (! Hash::check($data['current_password'], $user->password)) {
            return false;
        }

        // Update ke password baru
        $user->password = Hash::make($data['password']);
        return $user->save();
    }
}