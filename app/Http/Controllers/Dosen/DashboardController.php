<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Statistik: Jadwal minggu ini
        $weekScheduleCount = Schedule::where(function ($q) use ($userId) {
                $q->where('examiner_1_id', $userId)->orWhere('examiner_2_id', $userId);
            })
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Statistik: Jadwal yang belum dinilai oleh dosen ini
        $unassessedCount = Schedule::where(function ($q) use ($userId) {
                $q->where('examiner_1_id', $userId)->orWhere('examiner_2_id', $userId);
            })
            ->whereDoesntHave('assessments', function ($q) use ($userId) {
                $q->where('examiner_id', $userId);
            })
            ->count();

        // Statistik: Total sidang yang sudah dinilai & dikunci
        $totalAssessed = Assessment::where('examiner_id', $userId)
            ->where('is_locked', true)
            ->count();

        // Statistik: Rata-rata nilai yang diberikan dosen ini
        $avgScore = Assessment::where('examiner_id', $userId)
            ->where('is_locked', true)
            ->avg('total_score');

        // Statistik: Total semua jadwal sebagai penguji
        $totalSchedules = Schedule::where(function ($q) use ($userId) {
                $q->where('examiner_1_id', $userId)->orWhere('examiner_2_id', $userId);
            })->count();

        // Data: 5 jadwal sidang mendatang
        $upcomingSchedules = Schedule::with(['submission.student', 'examiner1', 'examiner2'])
            ->where(function ($q) use ($userId) {
                $q->where('examiner_1_id', $userId)->orWhere('examiner_2_id', $userId);
            })
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('time_start')
            ->take(5)
            ->get();

        // Data: Jadwal yang perlu segera dinilai (belum ada assessment dari dosen ini)
        $pendingAssessments = Schedule::with(['submission.student'])
            ->where(function ($q) use ($userId) {
                $q->where('examiner_1_id', $userId)->orWhere('examiner_2_id', $userId);
            })
            ->whereDoesntHave('assessments', function ($q) use ($userId) {
                $q->where('examiner_id', $userId);
            })
            ->orderBy('date')
            ->take(5)
            ->get();

        return view('dosen.dashboard', compact(
            'weekScheduleCount', 'unassessedCount', 'totalAssessed',
            'avgScore', 'totalSchedules', 'upcomingSchedules', 'pendingAssessments'
        ));
    }
}
