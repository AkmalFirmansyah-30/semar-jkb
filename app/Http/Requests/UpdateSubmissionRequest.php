<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $submission = $this->route('submission');

        return $this->user()->id === $submission->user_id
            && in_array($submission->status, ['revisi_tu', 'ditolak']);
    }

    public function rules(): array
    {
        return [
            'title'    => 'required|string|max:500',
            'document' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul penelitian wajib diisi.',
            'title.max'      => 'Judul penelitian maksimal 500 karakter.',
            'document.mimes' => 'File harus berformat PDF.',
            'document.max'   => 'Ukuran file maksimal 5MB.',
        ];
    }
}
