<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $schedules = Schedule::with(['submission.student', 'examiner1', 'examiner2', 'assessments'])
            ->where(function ($q) use ($userId) {
                $q->where('examiner_1_id', $userId)->orWhere('examiner_2_id', $userId);
            })
            ->orderBy('date', 'desc')
            ->get();

        return view('dosen.jadwal', compact('schedules'));
    }
}
