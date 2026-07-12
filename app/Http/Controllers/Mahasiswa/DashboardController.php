<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $latestSubmission = Submission::with(['schedule.assessments.examiner', 'schedule.examiner1', 'schedule.examiner2'])
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('mahasiswa.dashboard', compact('latestSubmission'));
    }
}
