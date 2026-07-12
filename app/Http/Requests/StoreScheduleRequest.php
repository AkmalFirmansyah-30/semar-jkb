<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'submission_id' => 'required|exists:submissions,id',
            'date'          => 'required|date|after_or_equal:today',
            'time_start'    => 'required',
            'time_end'      => 'required|after:time_start',
            'room'          => 'required|string|max:255',
            'examiner_1_id' => 'required|exists:users,id',
            'examiner_2_id' => 'required|exists:users,id|different:examiner_1_id',
        ];
    }

    public function messages(): array
    {
        return [
            'submission_id.required' => 'Pengajuan wajib dipilih.',
            'submission_id.exists'   => 'Pengajuan yang dipilih tidak ditemukan.',
            'date.required'          => 'Tanggal sidang wajib diisi.',
            'date.after_or_equal'    => 'Tanggal sidang tidak boleh di masa lalu.',
            'time_start.required'    => 'Waktu mulai wajib diisi.',
            'time_end.required'      => 'Waktu selesai wajib diisi.',
            'time_end.after'         => 'Waktu selesai harus setelah waktu mulai.',
            'room.required'          => 'Ruangan wajib diisi.',
            'examiner_1_id.required' => 'Dosen Penguji 1 wajib dipilih.',
            'examiner_2_id.required' => 'Dosen Penguji 2 wajib dipilih.',
            'examiner_2_id.different' => 'Dosen Penguji 2 harus berbeda dengan Penguji 1.',
        ];
    }
}
