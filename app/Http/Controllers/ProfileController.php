<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;  // <-- PENTING: Tambahkan ini untuk menggunakan Log
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
  public function edit()
  {
    $user = Auth::user();
    // Path view disesuaikan dengan kode Anda
    return view('pages.users.profile', compact('user'));
  }

  public function update(Request $request)
  {
    // -- Kode di bawah ini tidak akan berjalan jika dd() di atas aktif --
    // -- Hapus atau beri komentar pada dd() di atas untuk melanjutkan ke Log --
    $request->validate([
      'profile_photo_222297' => 'required|image|max:2048',
    ]);
    Log::info('Memulai proses update profil untuk user: ' . Auth::id());

    $user = Auth::user();

    $validator = Validator::make($request->all(), [
      'name_222297'          => 'required|string|max:255',
      'gender_222297'        => 'nullable|in:male,female',
      'address_222297'       => 'nullable|string',
      'phone_222297'         => 'nullable|string',
      'birth_date_222297'    => 'nullable|date',
      'profile_photo_222297' => 'nullable|image|max:2048',
      'password_222297'      => ['nullable', 'confirmed', Password::min(8)],
    ]);

    if ($validator->fails()) {
      Log::error('Validasi Gagal!', $validator->errors()->toArray());
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    Log::info('Validasi Berhasil.');

    $userData = $request->except(['_token', '_method', 'password_222297', 'profile_photo_222297']);
    Log::info('Data awal yang akan diupdate (sebelum foto & password):', $userData);

    if ($request->filled('password_222297')) {
      $userData['password_222297'] = Hash::make($request->password_222297);
      Log::info('Password baru telah di-hash.');
    }

    if ($request->hasFile('profile_photo_222297')) {
      Log::info('Terdeteksi file foto baru. Memulai proses upload.');

      if ($user->profile_photo_222297) {
        Log::info('Menghapus foto lama: ' . $user->profile_photo_222297);
        Storage::disk('public')->delete($user->profile_photo_222297);
      }

      $path = $request->file('profile_photo_222297')->store('profile_photos', 'public');
      Log::info('Foto baru berhasil disimpan di path: ' . $path);

      $userData['profile_photo_222297'] = $path;
    } else {
      Log::warning('Tidak ada file foto baru yang diupload pada request ini.');
    }

    Log::info('Data final yang siap di-update ke database:', $userData);
    $user->update($userData);
    Log::info('Proses update ke database selesai.');

    return redirect()
      ->route('profile.edit')
      ->with('success', 'Profile updated successfully!');
  }
}
