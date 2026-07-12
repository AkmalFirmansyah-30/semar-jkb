<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $userId,
            'nim_nip' => 'nullable|string|max:50|unique:users,nim_nip,' . $userId,
            'role'    => 'required|in:admin,dosen,mahasiswa',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Nama pengguna wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'email.unique'     => 'Email sudah digunakan pengguna lain.',
            'nim_nip.unique'   => 'NIM/NIP sudah digunakan pengguna lain.',
            'role.required'    => 'Role pengguna wajib dipilih.',
            'role.in'          => 'Role tidak valid. Pilih: Admin, Dosen, atau Mahasiswa.',
        ];
    }
}
