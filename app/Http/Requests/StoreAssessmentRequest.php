<?php

namespace App\Http\Requests;

use App\Models\Assessment;
use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $schedule = $this->route('schedule');
        $userId = $this->user()->id;

        // Pastikan dosen ini memang penguji di jadwal ini
        if ($schedule->examiner_1_id !== $userId && $schedule->examiner_2_id !== $userId) {
            return false;
        }

        // Pastikan nilai belum dikunci
        $existing = Assessment::where('schedule_id', $schedule->id)
            ->where('examiner_id', $userId)
            ->first();

        if ($existing && $existing->is_locked) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'score_presentation' => 'required|integer|min:0|max:100',
            'score_material'     => 'required|integer|min:0|max:100',
            'score_qna'          => 'required|integer|min:0|max:100',
            'revision_notes'     => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'score_presentation.required' => 'Nilai presentasi wajib diisi.',
            'score_presentation.integer'  => 'Nilai presentasi harus berupa angka bulat.',
            'score_presentation.min'      => 'Nilai presentasi minimal 0.',
            'score_presentation.max'      => 'Nilai presentasi maksimal 100.',
            'score_material.required'     => 'Nilai materi wajib diisi.',
            'score_material.integer'      => 'Nilai materi harus berupa angka bulat.',
            'score_material.min'          => 'Nilai materi minimal 0.',
            'score_material.max'          => 'Nilai materi maksimal 100.',
            'score_qna.required'          => 'Nilai tanya jawab wajib diisi.',
            'score_qna.integer'           => 'Nilai tanya jawab harus berupa angka bulat.',
            'score_qna.min'              => 'Nilai tanya jawab minimal 0.',
            'score_qna.max'              => 'Nilai tanya jawab maksimal 100.',
            'revision_notes.max'          => 'Catatan revisi maksimal 2000 karakter.',
        ];
    }
}
