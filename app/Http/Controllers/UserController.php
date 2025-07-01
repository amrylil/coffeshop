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
      'email'         => 'required|email|unique:users',
      'name'          => 'required|string|max:255',
      'password'      => 'required|string|min:8',
      'gender'        => 'nullable|in:male,female',
      'role'          => 'required|string',
      'address'       => 'nullable|string',
      'phone'         => 'nullable|string',
      'birth_date'    => 'nullable|date',
      'profile_photo' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $userData             = $request->all();
    $userData['password'] = Hash::make($request->password);

    // Handle profile photo upload if exists
    if ($request->hasFile('profile_photo')) {
      $path                      = $request->file('profile_photo')->store('profile_photos', 'public');
      $userData['profile_photo'] = $path;
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
      'email'         => ['required', 'email', Rule::unique('users', 'email')->ignore($user)],
      'name'          => 'required|string|max:255',
      'gender'        => 'nullable|in:male,female',
      'role'          => 'required|string',
      'address'       => 'nullable|string',
      'phone'         => 'nullable|string',
      'birth_date'    => 'nullable|date',
      'profile_photo' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    // Ambil semua data kecuali yang tidak perlu diupdate secara langsung
    $userData = $request->except(['_token', '_method', 'password', 'profile_photo']);

    // Update password hanya jika diisi
    if ($request->filled('password')) {
      $userData['password'] = Hash::make($request->password);
    }

    // [PERBAIKAN & LOGIKA BARU] Handle upload foto profil
    if ($request->hasFile('profile_photo')) {
      // 1. Hapus foto lama jika ada
      if ($user->profile_photo) {
        Storage::disk('public')->delete($user->profile_photo);
      }

      // 2. Simpan foto baru dan dapatkan path-nya
      $path = $request->file('profile_photo')->store('profile_photos', 'public');

      // 3. Masukkan path foto baru ke data yang akan diupdate
      $userData['profile_photo'] = $path;
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
    if ($user->profile_photo) {
      Storage::disk('public')->delete($user->profile_photo);
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
      'role' => 'required|string',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    $user->update([
      'role' => $request->role
    ]);

    return redirect()
      ->route('users.index')
      ->with('success', 'User role updated successfully');
  }
}
