<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Submission;
use App\Models\User;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['submission.student', 'examiner1', 'examiner2'])
            ->latest()
            ->get();

        $approvedSubmissions = Submission::with('student')
            ->where('status', 'terverifikasi')
            ->get();

        $dosens = User::where('role', 'dosen')->get();

        return view('admin.jadwal', compact('schedules', 'approvedSubmissions', 'dosens'));
    }

    public function store(StoreScheduleRequest $request)
    {
        $validated = $request->validated();

        // --- Validasi Bentrok Jadwal Dosen ---
        $conflict = $this->checkScheduleConflict(
            $validated['date'],
            $validated['time_start'],
            $validated['time_end'],
            $validated['examiner_1_id'],
            $validated['examiner_2_id']
        );

        if ($conflict) {
            return redirect()->route('admin.jadwal')
                ->with('error', $conflict)
                ->withInput();
        }

        Schedule::create($validated);

        Submission::find($validated['submission_id'])->update(['status' => 'dijadwalkan']);

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal sidang berhasil dibuat.');
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $validated = $request->validated();

        // --- Validasi Bentrok Jadwal Dosen (kecuali jadwal ini sendiri) ---
        $conflict = $this->checkScheduleConflict(
            $validated['date'],
            $validated['time_start'],
            $validated['time_end'],
            $validated['examiner_1_id'],
            $validated['examiner_2_id'],
            $schedule->id // exclude current schedule
        );

        if ($conflict) {
            return redirect()->route('admin.jadwal')
                ->with('error', $conflict)
                ->withInput();
        }

        $schedule->update($validated);

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->submission->update(['status' => 'terverifikasi']);
        $schedule->delete();

        return redirect()->route('admin.jadwal')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Rekapitulasi Nilai — Tabel lengkap penilaian sidang
     */
    public function rekapitulasi()
    {
        $schedules = Schedule::with([
            'submission.student',
            'examiner1',
            'examiner2',
            'assessments'
        ])->latest()->get();

        return view('admin.rekapitulasi', compact('schedules'));
    }

    /**
     * Cek apakah dosen penguji memiliki jadwal yang bentrok.
     * Bentrok = tanggal sama DAN waktu overlap.
     *
     * @param string|null $excludeId  ID jadwal yang dikecualikan (untuk update)
     * @return string|null  Pesan error jika bentrok, null jika aman.
     */
    private function checkScheduleConflict(
        string $date,
        string $timeStart,
        string $timeEnd,
        int $examiner1Id,
        int $examiner2Id,
        ?int $excludeId = null
    ): ?string {
        $examinerIds = [$examiner1Id, $examiner2Id];

        foreach ($examinerIds as $examinerId) {
            $query = Schedule::where('date', $date)
                ->where(function ($q) use ($timeStart, $timeEnd) {
                    // Overlap logic: existing.start < new.end AND existing.end > new.start
                    $q->where('time_start', '<', $timeEnd)
                      ->where('time_end', '>', $timeStart);
                })
                ->where(function ($q) use ($examinerId) {
                    $q->where('examiner_1_id', $examinerId)
                      ->orWhere('examiner_2_id', $examinerId);
                });

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            $conflicting = $query->with('submission.student')->first();

            if ($conflicting) {
                $dosenName = User::find($examinerId)->name;
                $studentName = $conflicting->submission->student->name ?? 'mahasiswa lain';
                $conflictTime = \Carbon\Carbon::parse($conflicting->time_start)->format('H:i') . ' - ' . \Carbon\Carbon::parse($conflicting->time_end)->format('H:i');

                return "Jadwal bentrok! Dosen {$dosenName} sudah dijadwalkan menguji {$studentName} pada tanggal yang sama ({$conflictTime}).";
            }
        }

        return null;
    }
}
