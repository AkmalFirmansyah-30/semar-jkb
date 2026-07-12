<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssessmentRequest;
use App\Models\Schedule;
use App\Models\Assessment;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function show(Schedule $schedule)
    {
        $userId = Auth::id();

        // Pastikan dosen ini memang penguji di jadwal ini
        if ($schedule->examiner_1_id !== $userId && $schedule->examiner_2_id !== $userId) {
            abort(403);
        }

        $schedule->load(['submission.student', 'examiner1', 'examiner2']);

        // Ambil penilaian yang sudah ada (jika ada)
        $assessment = Assessment::where('schedule_id', $schedule->id)
            ->where('examiner_id', $userId)
            ->first();

        return view('dosen.penilaian', compact('schedule', 'assessment'));
    }

    public function storeOrUpdate(StoreAssessmentRequest $request, Schedule $schedule)
    {
        // Autorisasi sudah ditangani oleh StoreAssessmentRequest::authorize()
        $validated = $request->validated();
        $userId = Auth::id();

        $totalScore = round(($validated['score_presentation'] + $validated['score_material'] + $validated['score_qna']) / 3, 2);

        Assessment::updateOrCreate(
            [
                'schedule_id' => $schedule->id,
                'examiner_id' => $userId,
            ],
            [
                'score_presentation' => $validated['score_presentation'],
                'score_material'     => $validated['score_material'],
                'score_qna'          => $validated['score_qna'],
                'total_score'        => $totalScore,
                'revision_notes'     => $validated['revision_notes'],
                'is_locked'          => $request->has('is_locked'),
            ]
        );

        return redirect()->route('dosen.jadwal')->with('success', 'Nilai berhasil disimpan.');
    }
}
