<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $guarded = []; // Agar semua kolom nilai bisa diisi dengan mudah

    // 1. Penilaian ini terikat pada satu Jadwal Sidang
    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    // 2. Penilaian ini diberikan oleh satu Dosen Penguji (Tersambung ke tabel Users)
    public function examiner() {
        return $this->belongsTo(User::class, 'examiner_id');
    }
}