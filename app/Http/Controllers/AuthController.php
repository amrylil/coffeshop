<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
  /**
   * Show the login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function showLoginForm()
  {
    return view('pages.auth.login');
  }

  /**
   * Handle the login request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    // Validasi input
    $credentials = $request->validate(
      [
        'email'    => ['required', 'email'],
        'password' => 'required|min:8|max:10',
        'role'     => 'required|in:customer,admin',
      ],
      [
        'email.required'    => 'Email wajib diisi.',
        'email.email'       => 'Masukkan email yang valid.',
        'password.required' => 'Password wajib diisi.',
        'password.min'      => 'Password harus memiliki minimal 8 karakter.',
        'password.max'      => 'Password tidak boleh lebih dari 10 karakter.',
        'role.required'     => 'Role wajib dipilih.',
        'role.in'           => 'Role tidak valid.',
      ]
    );

    // Menambahkan log percobaan login
    Log::info('Attempting login for:', $credentials);  // Menyimpan log

    // Attempt login menggunakan kolom yang sudah disesuaikan
    if (Auth::attempt([
      'email'    => $credentials['email'],
      'password' => $credentials['password'],
      'role'     => $credentials['role']
    ])) {
      // Regenerasi session ID untuk keamanan
      $request->session()->regenerate();

      // Menyimpan data tambahan ke session, termasuk role
      session([
        // 'user_id'   => Auth::user()->email,
        'user_role' => Auth::user()->role,  // Role user, misalnya 'admin' atau 'user'
        'email'     => Auth::user()->email,  // Role user, misalnya 'admin' atau 'user'
        'name'      => Auth::user()->name,
      ]);

      // Redirect berdasarkan peran pengguna
      if (Auth::user()->role === 'admin') {
        return redirect()->intended(route('admin.menu.index'))->with('success', 'Login berhasil!');
      } else {
        return redirect()->intended('/')->with('success', 'Login berhasil!');
      }
    }

    Log::info('Session data after login attempt:', $request->session()->all());

    return back()->withErrors([
      'email' => 'Password dan email anda salah',
    ]);
  }

  /**
   * Show the registration form.
   *
   * @return \Illuminate\Http\Response
   */
  public function showRegisterForm()
  {
    return view('pages.auth.register');
  }

  /**
   * Handle the registration request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  /**
   * Log the user out of the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name'          => 'required|string|max:255',
      'email'         => 'required|string|email|max:255|unique:users,email',
      'password'      => 'required|string|min:8|confirmed',
      'gender'        => 'nullable|string',
      'phone'         => 'nullable|string',
      'address'       => 'nullable|string',
      'birth_date'    => 'nullable|date',
      'profile_photo' => 'nullable|image|max:2048',  // Menambahkan validasi untuk file gambar
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput($request->except('password', 'password_confirmation'));
    }

    // Handle profile photo upload
    $profilePhoto = null;
    if ($request->hasFile('profile_photo')) {
      $file     = $request->file('profile_photo');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $file->storeAs('public/profile_photos', $fileName);
      $profilePhoto = 'profile_photos/' . $fileName;
    }

    // Create user
    $user = User::create([
      'name'          => $request->name,
      'email'         => $request->email,
      'password'      => Hash::make($request->password),
      'gender'        => $request->gender ?? null,
      'address'       => $request->address ?? null,
      'phone'         => $request->phone ?? null,
      'birth_date'    => $request->birth_date ?? null,
      'profile_photo' => $profilePhoto,
      'role'          => 'customer',
    ]);

    return redirect('/login');
  }

  /**
   * Log the user out of the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
  }

  /**
   * Show user profile
   *
   * @return \Illuminate\View\View
   */
  public function profile()
  {
    return view('auth.profile', ['user' => Auth::user()]);
  }

  /**
   * Update user profile
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function updateProfile(Request $request)
  {
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
      'name'          => 'required|string|max:255',
      'phone'         => 'required|string|max:15',
      'address'       => 'required|string',
      'birth_date'    => 'required|date',
      'profile_photo' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
      return redirect()
        ->back()
        ->withErrors($validator)
        ->withInput();
    }

    // Update profile data
    $updateData = [
      'name'       => $request->name,
      'address'    => $request->address,
      'phone'      => $request->phone,
      'birth_date' => $request->birth_date,
    ];

    // Handle profile photo upload
    if ($request->hasFile('profile_photo')) {
      $file     = $request->file('profile_photo');
      $fileName = time() . '_' . $file->getClientOriginalName();
      $file->storeAs('public/profile_photos', $fileName);
      $updateData['profile_photo'] = 'profile_photos/' . $fileName;
    }

    User::where('email', $user->email)->update($updateData);

    return redirect()->back()->with('success', 'Profile updated successfully.');
  }

  /**
   * Show change password form
   *
   * @return \Illuminate\View\View
   */
  public function showChangePasswordForm()
  {
    return view('auth.change-password');
  }

  /**
   * Update user password
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function changePassword(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'current_password' => 'required',
      'password'         => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator);
    }

    $user = Auth::user();

    // Check current password
    if (!Hash::check($request->current_password, $user->password)) {
      return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    // Update password
    User::where('email', $user->email)->update([
      'password' => Hash::make($request->password),
    ]);

    return redirect()->back()->with('success', 'Password changed successfully.');
  }
}
