<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Schedule;
use App\Models\Assessment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Statistik Utama ---
        $totalSubmissions = Submission::count();
        $pendingCount = Submission::where('status', 'pending')->count();
        $scheduledCount = Schedule::count();
        $assessedCount = Assessment::where('is_locked', true)->count();

        // --- Statistik Tambahan ---
        $userCounts = [
            'mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'dosen'     => User::where('role', 'dosen')->count(),
            'admin'     => User::where('role', 'admin')->count(),
        ];

        $typeCounts = [
            'sempro' => Submission::where('type', 'sempro')->count(),
            'semhas' => Submission::where('type', 'semhas')->count(),
            'ta'     => Submission::where('type', 'ta')->count(),
        ];

        $statusCounts = [
            'pending'       => $pendingCount,
            'terverifikasi' => Submission::where('status', 'terverifikasi')->count(),
            'dijadwalkan'   => Submission::where('status', 'dijadwalkan')->count(),
            'lulus'         => Submission::where('status', 'lulus')->count(),
            'revisi_tu'     => Submission::where('status', 'revisi_tu')->count(),
        ];

        // --- Data Tabel ---
        $pendingSubmissions = Submission::with('student')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $upcomingSchedules = Schedule::with(['submission.student', 'examiner1', 'examiner2'])
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSubmissions', 'pendingCount', 'scheduledCount', 'assessedCount',
            'userCounts', 'typeCounts', 'statusCounts',
            'pendingSubmissions', 'upcomingSchedules'
        ));
    }
}
