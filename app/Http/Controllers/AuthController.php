<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.menu.index'));
            }
            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function showRegistrationForm()
    {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:15',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'address'       => 'nullable|string',
            'birth_date'    => 'nullable|date',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $this->authService->registerUser($validatedData);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function updateProfile(Request $request)
    {
        $user          = Auth::user();
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
            // field lain...
        ]);

        // Panggil service untuk update
        $this->authService->updateUserProfile($user, $validatedData);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Panggil service untuk ganti password
        $success = $this->authService->changeUserPassword($user, $validatedData);

        if (! $success) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    // Method lain seperti show form, dll.
}
