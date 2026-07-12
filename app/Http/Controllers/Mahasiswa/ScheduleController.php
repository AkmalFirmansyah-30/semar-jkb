<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        // Ambil pengajuan terbaru yang sudah dijadwalkan
        $submission = Submission::with(['schedule.assessments.examiner', 'schedule.examiner1', 'schedule.examiner2'])
            ->where('user_id', Auth::id())
            ->whereHas('schedule')
            ->latest()
            ->first();

        return view('mahasiswa.jadwal', compact('submission'));
    }
}
