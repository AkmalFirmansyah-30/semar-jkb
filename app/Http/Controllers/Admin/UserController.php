<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.pengguna', compact('users'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'nim_nip'  => $validated['nim_nip'] ?? null,
            'role'     => $validated['role'],
            'password' => Hash::make('password'),
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'nim_nip' => $validated['nim_nip'] ?? $user->nim_nip,
            'role'    => $validated['role'],
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }
}
