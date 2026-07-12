<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        $submissions = Submission::with('student')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.verifikasi', compact('submissions'));
    }

    public function approve(Submission $submission)
    {
        $submission->update(['status' => 'terverifikasi']);
        return redirect()->route('admin.verifikasi')->with('success', 'Pengajuan berhasil diterima.');
    }

    public function reject(Request $request, Submission $submission)
    {
        $request->validate(['admin_notes' => 'required|string']);

        $submission->update([
            'status' => 'revisi_tu',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.verifikasi')->with('success', 'Pengajuan ditolak. Mahasiswa diminta merevisi.');
    }
}
