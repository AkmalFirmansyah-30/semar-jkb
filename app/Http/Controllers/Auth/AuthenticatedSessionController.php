<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Cek kecocokan Email dan Password
        $request->authenticate();

        // 2. Buat sesi baru (Keamanan standar Laravel)
        $request->session()->regenerate();

        // 3. --- LOGIKA PENGALIHAN (REDIRECT) SEMAR JKB ---
        $role = $request->user()->role; // Ambil data 'role' dari user yang baru saja login

        if ($role === 'admin') {
            // Jika admin, lempar ke halaman dashboard admin
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'dosen') {
            // Jika dosen, lempar ke halaman dashboard dosen
            return redirect()->route('dosen.dashboard');
        } elseif ($role === 'mahasiswa') {
            // Jika mahasiswa, lempar ke halaman dashboard mahasiswa
            return redirect()->route('mahasiswa.dashboard');
        }

        // 4. Default fallback (Hanya untuk jaga-jaga jika role kosong/tidak terdaftar)
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}