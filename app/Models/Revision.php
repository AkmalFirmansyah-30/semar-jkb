<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $guarded = []; // Agar semua kolom bisa diisi dengan mudah

    // Revisi ini adalah milik dari satu Pengajuan (Submission)
    public function submission() {
        return $this->belongsTo(Submission::class);
    }
}