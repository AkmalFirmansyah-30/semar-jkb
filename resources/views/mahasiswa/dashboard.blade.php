@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 rounded-4 mb-4 shadow-sm" style="background: linear-gradient(135deg, #FFC837 0%, #F5A623 100%);">
        <div class="card-body p-4 p-md-5">
            <h2 class="fw-bolder text-white mb-2" style="text-shadow: 0 2px 4px rgba(0,0,0,0.05);">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}!!</h2>
            <p class="text-white mb-0" style="opacity: 0.95; font-size: 1.05rem;">Pantau status pendaftaran dan jadwal seminar Anda di sini.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card border shadow-sm rounded-4 h-100 bg-white" style="border-color: #f0f0f0 !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-file-earmark-text text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.85rem;">Status Pendaftaran</h6>
                        @if($latestSubmission)
                            @php
                                $statusMap = [
                                    'pending' => ['Menunggu Verifikasi', 'text-warning'],
                                    'revisi_tu' => ['Ditolak (Revisi)', 'text-danger'],
                                    'terverifikasi' => ['Diterima', 'text-success'],
                                    'dijadwalkan' => ['Dijadwalkan', 'text-primary'],
                                    'revisi_dosen' => ['Revisi Dosen', 'text-info'],
                                    'lulus' => ['Lulus', 'text-success'],
                                ];
                                $status = $statusMap[$latestSubmission->status] ?? ['Unknown', 'text-muted'];
                            @endphp
                            <h5 class="fw-bolder mb-0 {{ $status[1] }}">{{ $status[0] }}</h5>
                        @else
                            <h5 class="fw-bolder text-dark mb-0">Belum Ada</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border shadow-sm rounded-4 h-100 bg-white" style="border-color: #f0f0f0 !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-calendar-check text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.85rem;">Jadwal Seminar</h6>
                        @if($latestSubmission && $latestSubmission->schedule)
                            <h5 class="fw-bolder text-dark mb-0">{{ \Carbon\Carbon::parse($latestSubmission->schedule->date)->translatedFormat('d M Y') }}</h5>
                        @else
                            <h5 class="fw-bolder text-dark mb-0">Belum Ada</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card border shadow-sm rounded-4 h-100 bg-white" style="border-color: #f0f0f0 !important;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="bi bi-award text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.85rem;">Nilai Akhir</h6>
                        @if($latestSubmission && $latestSubmission->schedule && $latestSubmission->schedule->assessments->count() > 0)
                            @php $avg = $latestSubmission->schedule->assessments->avg('total_score'); @endphp
                            <h5 class="fw-bolder text-success mb-0">{{ number_format($avg, 1) }}</h5>
                        @else
                            <h5 class="fw-bolder text-dark mb-0">Belum Ada</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border shadow-sm rounded-4 overflow-hidden bg-white" style="border-color: #f0f0f0 !important;">
        <div class="row g-0 align-items-center">
            <div class="col-md-8 p-4 p-md-5">
                @if(!$latestSubmission)
                <span class="badge mb-3 px-3 py-2 rounded-pill fw-bold shadow-sm" style="background-color: #FFC837; color: #1A202C;">Langkah Selanjutnya</span>
                <h4 class="fw-bolder text-dark mb-3">Mulai Pengajuan Sidang Anda</h4>
                <p class="text-muted mb-4" style="line-height: 1.6;">Anda belum memiliki pengajuan sidang. Silakan ajukan sidang dengan melengkapi data dan mengunggah draf laporan Anda.</p>
                <a href="{{ route('mahasiswa.pengajuan') }}" class="btn fw-bold px-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #FFC837, #F5A623); color: #121212; border: none;">
                    Buat Pengajuan <i class="bi bi-arrow-right ms-1"></i>
                </a>
                @else
                <span class="badge mb-3 px-3 py-2 rounded-pill fw-bold shadow-sm" style="background-color: #FFC837; color: #1A202C;">Pengajuan Terbaru</span>
                <h4 class="fw-bolder text-dark mb-3">{{ $latestSubmission->title }}</h4>
                <p class="text-muted mb-4">Jenis: {{ $latestSubmission->type === 'ta' ? 'Tugas Akhir' : ($latestSubmission->type === 'semhas' ? 'Seminar Hasil' : 'Seminar Proposal') }}</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('mahasiswa.pengajuan') }}" class="btn btn-outline-dark fw-bold px-4 py-2 rounded-pill">Lihat Pengajuan</a>
                    @if($latestSubmission->schedule)
                    <a href="{{ route('mahasiswa.jadwal') }}" class="btn fw-bold px-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #FFC837, #F5A623); color: #121212; border: none;">
                        Lihat Jadwal <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    @endif
                </div>
                @endif
            </div>
            <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center p-4">
                <i class="bi bi-folder-plus" style="font-size: 9rem; color: #F5A623; opacity: 0.9;"></i>
            </div>
        </div>
    </div>
</div>
@endsection