<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'          => 'required|in:sempro,semhas,ta',
            'supervisor_id' => 'required|exists:users,id',
            'title'         => 'required|string|max:500',
            'document'      => 'required|file|mimes:pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'          => 'Jenis sidang wajib dipilih.',
            'type.in'                => 'Jenis sidang tidak valid. Pilih: Sempro, Semhas, atau TA.',
            'supervisor_id.required' => 'Dosen pembimbing wajib dipilih.',
            'supervisor_id.exists'   => 'Dosen pembimbing yang dipilih tidak ditemukan.',
            'title.required'         => 'Judul penelitian wajib diisi.',
            'title.max'              => 'Judul penelitian maksimal 500 karakter.',
            'document.required'      => 'File draf PDF wajib diunggah.',
            'document.mimes'         => 'File harus berformat PDF.',
            'document.max'           => 'Ukuran file maksimal 5MB.',
        ];
    }
}
