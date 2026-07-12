<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    // Pengajuan ini milik satu Mahasiswa
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Pengajuan ini punya satu Dosen Pembimbing
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    // Pengajuan ini punya satu Jadwal
    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    // Pengajuan ini punya satu Laporan Revisi Final
    public function revision()
    {
        return $this->hasOne(Revision::class);
    }
}