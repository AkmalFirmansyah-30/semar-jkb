<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = []; // Agar semua kolom bisa diisi dengan mudah

    // 1. Jadwal ini adalah milik dari satu Pengajuan (Submission)
    public function submission() {
        return $this->belongsTo(Submission::class);
    }

    // 2. Jadwal ini memiliki Dosen Penguji 1 (Terhubung ke tabel Users)
    public function examiner1() {
        return $this->belongsTo(User::class, 'examiner_1_id');
    }

    // 3. Jadwal ini memiliki Dosen Penguji 2 (Terhubung ke tabel Users)
    public function examiner2() {
        return $this->belongsTo(User::class, 'examiner_2_id');
    }

    // 4. Jadwal ini memiliki banyak Penilaian (dari masing-masing penguji)
    public function assessments() {
        return $this->hasMany(Assessment::class);
    }
}