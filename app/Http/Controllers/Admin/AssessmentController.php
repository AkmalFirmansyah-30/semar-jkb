<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;

class AssessmentController extends Controller
{
    /**
     * Admin menghapus/mereset nilai dosen.
     * Digunakan jika terjadi kesalahan sistem atau pelanggaran akademik.
     */
    public function destroy(Assessment $assessment)
    {
        $assessment->delete();

        return redirect()->route('admin.rekapitulasi')
            ->with('success', 'Nilai berhasil direset/dihapus.');
    }
}
