<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'          => 'required|date',
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
            'date.required'          => 'Tanggal sidang wajib diisi.',
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
