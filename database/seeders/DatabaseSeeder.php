<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
        * Seed the application's database.
        */
    public function run(): void
    {
        // 1. Akun Admin TU
        User::create([
            'name' => 'Admin Tata Usaha JKB',
            'email' => 'admin@pnc.ac.id',
            'password' => Hash::make('password'), // Password-nya: password
            'nim_nip' => '198001012000031001',
            'role' => 'admin',
        ]);

        // 2. Akun Dosen (Penguji / Pembimbing)
        User::create([
            'name' => 'Dr. Budi Santoso, M.Kom',
            'email' => 'dosen@pnc.ac.id',
            'password' => Hash::make('password'), // Password-nya: password
            'nim_nip' => '197502022005011002',
            'role' => 'dosen',
        ]);

        // 3. Akun Mahasiswa
        User::create([
            'name' => 'Mahasiswa Semester Akhir',
            'email' => 'mahasiswa@pnc.ac.id',
            'password' => Hash::make('password'), // Password-nya: password
            'nim_nip' => '240202001',
            'role' => 'mahasiswa',
        ]);
    }
}