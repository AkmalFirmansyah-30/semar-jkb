<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'nim_nip', 'role', 'avatar', 'prodi',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Pengajuan milik mahasiswa ini
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'user_id');
    }

    // Jadwal dimana user ini jadi penguji 1
    public function schedulesAsExaminer1()
    {
        return $this->hasMany(Schedule::class, 'examiner_1_id');
    }

    // Jadwal dimana user ini jadi penguji 2
    public function schedulesAsExaminer2()
    {
        return $this->hasMany(Schedule::class, 'examiner_2_id');
    }

    // Penilaian yang diberikan dosen ini
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'examiner_id');
    }

    // Pengajuan yang dibimbing oleh dosen ini
    public function supervisedSubmissions()
    {
        return $this->hasMany(Submission::class, 'supervisor_id');
    }

    // Semua jadwal dimana user ini jadi penguji (gabungan examiner 1 & 2)
    public function schedules()
    {
        return Schedule::where('examiner_1_id', $this->id)
            ->orWhere('examiner_2_id', $this->id);
    }
}
