<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar semua user.
     */
    public function index(): Response
    {
        $users = User::latest()->get()->map(function ($user) {
            return [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'role'              => $user->role,
                'profile_photo_url' => $user->profile_photo
                ? Storage::url($user->profile_photo)
                : null,
            ];
        });

        return Inertia::render('Admin/User', [
            'users' => $users,
        ]);
    }

    /**
     * Menyimpan user baru yang dikirim dari form modal.
     */
    public function store(Request $request): RedirectResponse
    {
        // ## VALIDASI DISATUKAN DI SINI ##
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'role'          => 'required|string|in:admin,cashier,user',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($request->hasFile('profile_photo')) {
            $validatedData['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        User::create($validatedData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Memperbarui user yang ada dari form modal.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // ## VALIDASI DISATUKAN DI SINI ##
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'      => 'nullable|string|min:8', // Password opsional saat update
            'role'          => 'required|string|in:admin,cashier,user',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        // Update password hanya jika diisi di form
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $validatedData['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $user->update($validatedData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->transaksi()->exists()) {
            return redirect()->back()
                ->with('error', 'Failed to delete! User has transaction history.');
        }

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * (Opsional) Menampilkan detail spesifik user.
     */
    public function show(User $user): Response
    {
        $user->profile_photo_url = $user->profile_photo ? Storage::url($user->profile_photo) : null;
        return Inertia::render('Admin/User', [
            'user' => $user,
        ]);
    }
}