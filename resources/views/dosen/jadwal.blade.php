@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <h3 class="fw-bolder text-dark">Jadwal Menguji</h3>
        <p class="text-muted">Daftar jadwal sidang dimana Anda ditugaskan sebagai dosen penguji.</p>
    </div>


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            @if($schedules->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Waktu & Tempat</th>
                            <th class="py-3">Mahasiswa</th>
                            <th class="py-3">Jenis Sidang</th>
                            <th class="pe-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        @php
                            $hasAssessment = $schedule->assessments->where('examiner_id', Auth::id())->count() > 0;
                        @endphp
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark"><i class="bi bi-calendar-event text-warning me-1"></i> {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('d M Y') }}</div>
                                <div class="text-muted small">{{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }} - {{ $schedule->room }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $schedule->submission->student->name }}</div>
                                <div class="text-muted small text-truncate" style="max-width:250px;">{{ $schedule->submission->title }}</div>
                            </td>
                            <td>
                                @php $bc = match($schedule->submission->type) { 'ta'=>'primary','semhas'=>'info','sempro'=>'success',default=>'secondary' }; @endphp
                                <span class="badge bg-{{ $bc }} bg-opacity-10 text-{{ $bc }} border border-{{ $bc }} rounded-pill px-3">
                                    {{ $schedule->submission->type === 'ta' ? 'Tugas Akhir' : ($schedule->submission->type === 'semhas' ? 'Seminar Hasil' : 'Seminar Proposal') }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('documents.show', $schedule->submission->document_path) }}" target="_blank" class="btn btn-sm btn-light border text-danger fw-bold rounded-pill px-3 me-1"><i class="bi bi-file-pdf-fill"></i> PDF</a>
                                @if(!$hasAssessment)
                                <a href="{{ route('dosen.penilaian', $schedule) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-bold shadow-sm"><i class="bi bi-pencil-square"></i> Nilai</a>
                                @else
                                <a href="{{ route('dosen.penilaian', $schedule) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold"><i class="bi bi-eye"></i> Lihat</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-check text-success" style="font-size: 4rem; opacity: 0.4;"></i>
                <h5 class="fw-bold text-dark mt-3">Tidak Ada Jadwal</h5>
                <p class="text-muted">Anda belum ditugaskan sebagai penguji di sidang manapun.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection