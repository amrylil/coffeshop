<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  /**
   * Display a listing of the users.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::all();
    return view('pages.admin.users.index', ['users' => $users]);
  }

  /**
   * Show the form for creating a new user.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.admin.users.create');
  }

  /**
   * Store a newly created user in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email_222297'         => 'required|email|unique:users_222297',
      'name_222297'          => 'required|string|max:255',
      'password_222297'      => 'required|string|min:8',
      'gender_222297'        => 'nullable|in:male,female',
      'role_222297'          => 'required|string',
      'address_222297'       => 'nullable|string',
      'phone_222297'         => 'nullable|string',
      'birth_date_222297'    => 'nullable|date',
      'profile_photo_222297' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $userData                    = $request->all();
    $userData['password_222297'] = Hash::make($request->password_222297);

    // Handle profile photo upload if exists
    if ($request->hasFile('profile_photo_222297')) {
      $path                             = $request->file('profile_photo_222297')->store('profile_photos', 'public');
      $userData['profile_photo_222297'] = $path;
    }

    User::create($userData);

    return redirect()
      ->route('admin.users.index')
      ->with('success', 'User created successfully');
  }

  /**
   * Display the specified user.
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::findOrFail($id);
    return view('pages.admin.users.show', compact('user'));
  }

  /**
   * Show the form for editing the specified user.
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = User::findOrFail($id);
    return view('pages.admin.users.edit', compact('user'));
  }

  /**
   * Update the specified user in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
      // [PERBAIKAN] Menggunakan Rule::unique untuk kemudahan membaca dan keamanan
      'email_222297'         => ['required', 'email', Rule::unique('users_222297', 'email_222297')->ignore($user)],
      'name_222297'          => 'required|string|max:255',
      'gender_222297'        => 'nullable|in:male,female',
      'role_222297'          => 'required|string',
      'address_222297'       => 'nullable|string',
      'phone_222297'         => 'nullable|string',
      'birth_date_222297'    => 'nullable|date',
      'profile_photo_222297' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    // Ambil semua data kecuali yang tidak perlu diupdate secara langsung
    $userData = $request->except(['_token', '_method', 'password_222297', 'profile_photo_222297']);

    // Update password hanya jika diisi
    if ($request->filled('password_222297')) {
      $userData['password_222297'] = Hash::make($request->password_222297);
    }

    // [PERBAIKAN & LOGIKA BARU] Handle upload foto profil
    if ($request->hasFile('profile_photo_222297')) {
      // 1. Hapus foto lama jika ada
      if ($user->profile_photo_222297) {
        Storage::disk('public')->delete($user->profile_photo_222297);
      }

      // 2. Simpan foto baru dan dapatkan path-nya
      $path = $request->file('profile_photo_222297')->store('profile_photos', 'public');

      // 3. Masukkan path foto baru ke data yang akan diupdate
      $userData['profile_photo_222297'] = $path;
    }

    $user->update($userData);

    return redirect()
      ->route('admin.users.index')
      ->with('success', 'User updated successfully');
  }

  /**
   * Remove the specified user from storage.
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($email): RedirectResponse
  {
    // Cari user berdasarkan email sebagai primary key
    $user = User::findOrFail($email);

    // -- VALIDASI SEBELUM MENGHAPUS --
    // Cek apakah user masih punya item di keranjang ATAU sudah pernah bertransaksi
    if ($user->keranjang()->exists() || $user->transaksi()->exists()) {
      // Jika ya, jangan hapus. Redirect kembali dengan pesan error.
      return redirect()
        ->back()
        ->with('error', 'Gagal menghapus! User ini masih memiliki riwayat di keranjang atau transaksi.');
    }

    // -- JIKA VALIDASI LOLOS, LANJUTKAN HAPUS --

    // (Opsional) Hapus foto profil dari storage jika ada
    if ($user->profile_photo_222297) {
      Storage::disk('public')->delete($user->profile_photo_222297);
    }

    $user->delete();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()
      ->route('admin.users.index')
      ->with('success', 'User berhasil dihapus.');
  }

  /**
   * Change user role.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function changeRole(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
      'role_222297' => 'required|string',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $user->update([
      'role_222297' => $request->role_222297
    ]);

    return redirect()
      ->route('users.index')
      ->with('success', 'User role updated successfully');
  }
}
