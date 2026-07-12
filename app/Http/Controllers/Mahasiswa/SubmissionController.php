<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        // Mengambil daftar dosen untuk dropdown form pengajuan
        $dosens = User::where('role', 'dosen')->get();
        
        // Mengambil data pengajuan khusus milik mahasiswa yang sedang login
        $submissions = Submission::with('supervisor')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('mahasiswa.pengajuan', compact('dosens', 'submissions'));
    }

    public function store(StoreSubmissionRequest $request)
    {
        $validated = $request->validated();

        $file = $request->file('document');
        
        // Standarisasi Nama File: [Timestamp]_SEMAR_[NamaMahasiswa]_[NamaAsliFile].pdf
        $safeName = str_replace(' ', '', Auth::user()->name); // Hilangkan spasi pada nama
        $filename = time() . '_SEMAR_' . $safeName . '_' . $file->getClientOriginalName();
        
        // Simpan ke folder public/documents
        $file->storeAs('documents', $filename, 'public');

        Submission::create([
            'user_id'       => Auth::id(),
            'supervisor_id' => $validated['supervisor_id'],
            'type'          => $validated['type'],
            'title'         => $validated['title'],
            'document_path' => $filename,
            'status'        => 'pending',
        ]);

        return redirect()->route('mahasiswa.pengajuan')->with('success', 'Pengajuan berhasil dikirim!');
    }

    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        // Autorisasi sudah ditangani oleh UpdateSubmissionRequest::authorize()
        $validated = $request->validated();

        // Reset status kembali ke pending setelah diperbaiki, dan kosongkan catatan admin
        $data = [
            'title' => $validated['title'], 
            'status' => 'pending', 
            'admin_notes' => null
        ];

        // Logika jika mahasiswa mengunggah file PDF baru
        if ($request->hasFile('document')) {
            // Hapus file lama di server
            if ($submission->document_path && Storage::disk('public')->exists('documents/' . $submission->document_path)) {
                Storage::disk('public')->delete('documents/' . $submission->document_path);
            }
            
            $file = $request->file('document');
            $safeName = str_replace(' ', '', Auth::user()->name);
            $filename = time() . '_SEMAR_' . $safeName . '_' . $file->getClientOriginalName();
            
            $file->storeAs('documents', $filename, 'public');
            $data['document_path'] = $filename;
        }

        $submission->update($data);

        return redirect()->route('mahasiswa.pengajuan')->with('success', 'Pengajuan berhasil diperbarui dan dikirim ulang.');
    }

    public function destroy(Submission $submission)
    {
        // Hanya bisa membatalkan pengajuan yang masih antre (pending)
        if ($submission->user_id !== Auth::id() || $submission->status !== 'pending') {
            abort(403, 'Pengajuan yang sudah diproses tidak dapat dibatalkan.');
        }

        // Hapus fisik file PDF-nya
        if ($submission->document_path && Storage::disk('public')->exists('documents/' . $submission->document_path)) {
            Storage::disk('public')->delete('documents/' . $submission->document_path);
        }

        $submission->delete();

        return redirect()->route('mahasiswa.pengajuan')->with('success', 'Pengajuan berhasil dibatalkan.');
    }
}