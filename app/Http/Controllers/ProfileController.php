<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // <-- PENTING: Tambahkan ini untuk mengelola file

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // --- TAMBAHAN: Logika Upload Foto Profil ---
        if ($request->hasFile('avatar')) {
            // Cek dan hapus foto lama jika ada (agar server tidak penuh)
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            
            // Simpan foto baru
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('avatars', $filename, 'public'); 
            
            // Masukkan nama file ke database
            $user->avatar = $filename; 
        }
        // ------------------------------------------

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}