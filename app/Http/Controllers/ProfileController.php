<?php
namespace App\Http\Controllers;

use App\Services\ProfileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class ProfileController extends RoutingController
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
        $this->middleware('auth');
    }

    /**
     * Menampilkan halaman edit profil.
     */
    public function edit()
    {
        return Inertia::render(
            'Users/Profile', ['user' => Auth::user()]);

    }

    /**
     * Menangani permintaan untuk memperbarui profil.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi data yang masuk
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'gender'        => 'nullable|in:male,female',
            'address'       => 'nullable|string',
            'phone'         => 'nullable|string',
            'birth_date'    => 'nullable|date',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'      => ['nullable', 'confirmed', Password::min(8)],
        ]);

        try {
            // Memanggil service untuk melakukan update
            $this->profileService->update(
                $user,
                $validatedData,
                $request->hasFile('profile_photo') ? $request->file('profile_photo') : null
            );

            return redirect()
                ->route('profile.edit')
                ->with('success', 'Profil berhasil diperbarui!');

        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}