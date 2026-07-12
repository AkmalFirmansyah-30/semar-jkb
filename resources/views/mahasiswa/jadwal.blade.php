@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    
    <div class="mb-4 d-flex align-items-center">
        <div class="bg-gold p-3 rounded-circle me-3 shadow-sm d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
            <i class="bi bi-calendar2-check-fill text-white fs-3"></i>
        </div>
        <div>
            <h3 class="fw-bolder text-dark mb-1">Jadwal & Hasil Sidang</h3>
            <p class="text-muted mb-0">Informasi pelaksanaan dan rekapitulasi penilaian akhir.</p>
        </div>
    </div>

    @if($submission && $submission->schedule)
    @php $schedule = $submission->schedule; @endphp
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history text-warning me-2"></i> Informasi Jadwal</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-check-circle-fill me-1"></i> Dijadwalkan
                        </span>
                        <h5 class="fw-bold mt-3 text-dark">{{ $submission->title }}</h5>
                        <p class="text-muted small">Jenis: {{ $submission->type === 'ta' ? 'Sidang Tugas Akhir' : ($submission->type === 'semhas' ? 'Seminar Hasil' : 'Seminar Proposal') }}</p>
                    </div>
                    <hr class="text-muted opacity-25">
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <p class="text-muted mb-1 small fw-semibold">Tanggal</p>
                            <h6 class="fw-bold text-dark">{{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l, d F Y') }}</h6>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1 small fw-semibold">Waktu</p>
                            <h6 class="fw-bold text-dark">{{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }} WIB</h6>
                        </div>
                        <div class="col-12 mt-3">
                            <p class="text-muted mb-1 small fw-semibold">Ruangan</p>
                            <h6 class="fw-bold text-dark"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $schedule->room }}</h6>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded-3">
                        <p class="text-muted mb-2 small fw-semibold">Tim Penguji:</p>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-person-video2 text-gold fs-4 me-3"></i>
                            <div>
                                <div class="fw-bold text-dark small">Penguji 1</div>
                                <div class="text-muted small">{{ $schedule->examiner1->name }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-video2 text-gold fs-4 me-3"></i>
                            <div>
                                <div class="fw-bold text-dark small">Penguji 2</div>
                                <div class="text-muted small">{{ $schedule->examiner2->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-award-fill text-warning me-2"></i> Hasil Penilaian Akhir</h5>
                </div>
                <div class="card-body p-4 p-md-5 d-flex flex-column">
                    @if($schedule->assessments->count() > 0)
                    <div class="mb-4">
                        @foreach($schedule->assessments as $assessment)
                        <div class="bg-light rounded-4 p-4 mb-3">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-check text-gold me-2"></i>{{ $assessment->examiner->name }}</h6>
                            <div class="row g-2 mb-3">
                                <div class="col-4 text-center">
                                    <div class="text-muted small fw-semibold">Presentasi</div>
                                    <div class="fw-bolder text-dark fs-5">{{ $assessment->score_presentation }}</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="text-muted small fw-semibold">Materi</div>
                                    <div class="fw-bolder text-dark fs-5">{{ $assessment->score_material }}</div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="text-muted small fw-semibold">Tanya Jawab</div>
                                    <div class="fw-bolder text-dark fs-5">{{ $assessment->score_qna }}</div>
                                </div>
                            </div>
                            <div class="text-center border-top pt-2">
                                <span class="text-muted small">Rata-rata: </span>
                                <span class="fw-bolder text-primary fs-5">{{ number_format($assessment->total_score, 1) }}</span>
                            </div>
                            @if($assessment->revision_notes)
                            <div class="alert alert-info border-0 bg-info bg-opacity-10 small mt-3 mb-0 rounded-3">
                                <i class="bi bi-chat-left-text-fill me-1"></i> <strong>Catatan Revisi:</strong> {{ $assessment->revision_notes }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center my-auto">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-3" style="width: 120px; height: 120px;">
                            <i class="bi bi-lock-fill text-secondary opacity-50" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Belum Tersedia</h5>
                        <p class="text-muted">Nilai akan muncul di sini setelah dosen penguji menyelesaikan proses penilaian.</p>
                        <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-dark text-start mt-4 rounded-3">
                            <i class="bi bi-info-circle-fill text-warning me-2"></i> <strong>Pemberitahuan:</strong> Harap hadir 15 menit sebelum jadwal sidang dimulai.
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-5 text-center">
            <i class="bi bi-calendar-x text-secondary" style="font-size: 5rem; opacity: 0.4;"></i>
            <h4 class="fw-bold text-dark mt-3">Belum Ada Jadwal Sidang</h4>
            <p class="text-muted">Jadwal akan ditampilkan setelah pengajuan Anda diverifikasi dan dijadwalkan oleh Admin.</p>
            <a href="{{ route('mahasiswa.pengajuan') }}" class="btn fw-bold px-4 py-2 rounded-pill shadow-sm mt-2" style="background: linear-gradient(135deg, #FFC837, #F5A623); color: #121212; border: none;">
                Buat Pengajuan <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection