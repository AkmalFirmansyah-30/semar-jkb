<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AssessmentController as AdminAssessmentController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\SubmissionController;
use App\Http\Controllers\Mahasiswa\ScheduleController as MahasiswaScheduleController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\ScheduleController as DosenScheduleController;
use App\Http\Controllers\Dosen\AssessmentController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ==========================================================
// KELOMPOK RUTE YANG WAJIB LOGIN (AUTH)
// ==========================================================
Route::middleware(['auth', 'verified'])->group(function () {

// --- RUTE TERMINAL PENGHUBUNG (PENGGANTI BAWAAN BREEZE) ---
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'dosen') {
            return redirect()->route('dosen.dashboard');
        } else {
            return redirect()->route('mahasiswa.dashboard');
        }
    })->name('dashboard');
    // ----------------------------------------------------------

    // --- 1. RUTE KHUSUS MAHASISWA ---
    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('role:mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan', [SubmissionController::class, 'index'])->name('pengajuan');
        Route::post('/pengajuan', [SubmissionController::class, 'store'])->name('pengajuan.store');
        Route::put('/pengajuan/{submission}', [SubmissionController::class, 'update'])->name('pengajuan.update');
        Route::delete('/pengajuan/{submission}', [SubmissionController::class, 'destroy'])->name('pengajuan.destroy');
        Route::get('/jadwal', [MahasiswaScheduleController::class, 'index'])->name('jadwal');
    });

    // --- 2. RUTE KHUSUS ADMIN ---
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifikasi');
        Route::patch('/verifikasi/{submission}/approve', [VerificationController::class, 'approve'])->name('verifikasi.approve');
        Route::patch('/verifikasi/{submission}/reject', [VerificationController::class, 'reject'])->name('verifikasi.reject');
        Route::get('/jadwal', [AdminScheduleController::class, 'index'])->name('jadwal');
        Route::post('/jadwal', [AdminScheduleController::class, 'store'])->name('jadwal.store');
        Route::put('/jadwal/{schedule}', [AdminScheduleController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{schedule}', [AdminScheduleController::class, 'destroy'])->name('jadwal.destroy');
        Route::get('/pengguna', [AdminUserController::class, 'index'])->name('pengguna');
        Route::post('/pengguna', [AdminUserController::class, 'store'])->name('pengguna.store');
        Route::put('/pengguna/{user}', [AdminUserController::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{user}', [AdminUserController::class, 'destroy'])->name('pengguna.destroy');
        Route::get('/rekapitulasi', [AdminScheduleController::class, 'rekapitulasi'])->name('rekapitulasi');
        Route::delete('/penilaian/{assessment}', [AdminAssessmentController::class, 'destroy'])->name('penilaian.destroy');
    });

    // --- 3. RUTE KHUSUS DOSEN ---
    Route::prefix('dosen')->name('dosen.')->middleware('role:dosen')->group(function () {
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        Route::get('/jadwal', [DosenScheduleController::class, 'index'])->name('jadwal');
        Route::get('/penilaian/{schedule}', [AssessmentController::class, 'show'])->name('penilaian');
        Route::post('/penilaian/{schedule}', [AssessmentController::class, 'storeOrUpdate'])->name('penilaian.store');
    });

    // --- 4. RUTE AKSES DOKUMEN ---
    Route::get('/documents/{filename}', [DocumentController::class, 'show'])
        ->where('filename', '.*')
        ->name('documents.show');

});

// ==========================================================
// RUTE PROFIL (BAWAAN BREEZE)
// ==========================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';