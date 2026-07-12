@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    {{-- Header Welcome --}}
    <div class="card border-0 rounded-4 mb-4 shadow-sm" style="background: linear-gradient(135deg, #FFC837 0%, #F5A623 100%);">
        <div class="card-body p-4 p-md-5">
            <h2 class="fw-bolder text-white mb-2" style="text-shadow: 0 2px 4px rgba(0,0,0,0.05);">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
            <p class="text-white mb-0" style="opacity: 0.95; font-size: 1.05rem;">Pantau jadwal menguji dan tugas penilaian Anda di sini.</p>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-up">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-calendar-event text-primary fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Jadwal Minggu Ini</h6>
                        <h4 class="fw-bolder text-dark mb-0">{{ $weekScheduleCount }} <span class="fs-6 fw-semibold text-muted">Sidang</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-up border-start border-warning border-4">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-pencil-square text-warning fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Belum Dinilai</h6>
                        <h4 class="fw-bolder text-dark mb-0">{{ $unassessedCount }} <span class="fs-6 fw-semibold text-muted">Mahasiswa</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-up">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-check2-all text-success fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Selesai Dinilai</h6>
                        <h4 class="fw-bolder text-dark mb-0">{{ $totalAssessed }} <span class="fs-6 fw-semibold text-muted">Sidang</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-up">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-graph-up-arrow text-info fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Rata-Rata Nilai</h6>
                        <h4 class="fw-bolder text-dark mb-0">{{ $avgScore ? number_format($avgScore, 1) : '—' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Action --}}
    @if($unassessedCount > 0)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-lightning-charge-fill text-gold me-2"></i>Perlu Penilaian Segera</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Mahasiswa</th>
                            <th class="py-3">Jenis Sidang</th>
                            <th class="py-3">Judul</th>
                            <th class="pe-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingAssessments as $sch)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center fw-bold me-3" style="width:38px;height:38px;font-size:0.85rem;">
                                        {{ strtoupper(substr($sch->submission->student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $sch->submission->student->name }}</div>
                                        <div class="text-muted small">{{ $sch->submission->student->nim_nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php $bc = match($sch->submission->type) { 'ta'=>'primary','semhas'=>'info','sempro'=>'success',default=>'secondary' }; @endphp
                                <span class="badge bg-{{ $bc }} bg-opacity-10 text-{{ $bc }} rounded-pill px-2 py-1">
                                    {{ $sch->submission->type === 'ta' ? 'Tugas Akhir' : ($sch->submission->type === 'semhas' ? 'Seminar Hasil' : 'Seminar Proposal') }}
                                </span>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;" title="{{ $sch->submission->title }}">{{ $sch->submission->title }}</div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('dosen.penilaian', $sch) }}" class="btn btn-sm fw-bold px-3 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #FFC837, #F5A623); color: #121212; border: none;">
                                    <i class="bi bi-pencil-fill me-1"></i> Nilai Sekarang
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Jadwal Sidang Mendatang --}}
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-calendar2-week text-primary me-2"></i>Jadwal Sidang Mendatang</h6>
                    <a href="{{ route('dosen.jadwal') }}" class="text-decoration-none small fw-bold text-gold">Lihat Semua <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="card-body p-4">
                    @forelse($upcomingSchedules as $sch)
                    <div class="d-flex align-items-start {{ !$loop->last ? 'mb-4 pb-4 border-bottom' : '' }}">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 text-center me-3" style="min-width: 60px;">
                            <div class="fw-bolder fs-5 lh-1 mb-1">{{ \Carbon\Carbon::parse($sch->date)->format('d') }}</div>
                            <div class="small fw-bold text-uppercase">{{ \Carbon\Carbon::parse($sch->date)->translatedFormat('M') }}</div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">{{ $sch->submission->student->name }}</h6>
                            <p class="text-muted small mb-1 text-truncate" style="max-width: 350px;" title="{{ $sch->submission->title }}">{{ $sch->submission->title }}</p>
                            <div class="d-flex gap-3 text-muted small">
                                <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($sch->time_start)->format('H:i') }} — {{ \Carbon\Carbon::parse($sch->time_end)->format('H:i') }} WIB</span>
                                <span><i class="bi bi-geo-alt me-1"></i>{{ $sch->room }}</span>
                            </div>
                        </div>
                        @php
                            $assessed = $sch->assessments->where('examiner_id', Auth::id())->first();
                        @endphp
                        @if($assessed && $assessed->is_locked)
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 ms-2 align-self-center"><i class="bi bi-lock-fill me-1"></i>Dikunci</span>
                        @elseif($assessed)
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 ms-2 align-self-center">Draft</span>
                        @else
                            <a href="{{ route('dosen.penilaian', $sch) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold ms-2 align-self-center">Nilai</a>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;">
                            <i class="bi bi-calendar-x fs-1"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Tidak Ada Jadwal Mendatang</h6>
                        <p class="text-muted small mb-0">Belum ada sidang yang dijadwalkan untuk Anda.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Ringkasan Statistik --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-bar-chart-line-fill text-success me-2"></i>Ringkasan Kinerja</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center me-3" style="width:40px;height:40px;">
                                <i class="bi bi-people-fill text-primary"></i>
                            </div>
                            <span class="text-muted fw-semibold">Total Ditugaskan Menguji</span>
                        </div>
                        <span class="fw-bolder text-dark fs-5">{{ $totalSchedules }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center me-3" style="width:40px;height:40px;">
                                <i class="bi bi-check-circle-fill text-success"></i>
                            </div>
                            <span class="text-muted fw-semibold">Sudah Dinilai & Dikunci</span>
                        </div>
                        <span class="fw-bolder text-dark fs-5">{{ $totalAssessed }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center me-3" style="width:40px;height:40px;">
                                <i class="bi bi-hourglass-split text-warning"></i>
                            </div>
                            <span class="text-muted fw-semibold">Menunggu Penilaian</span>
                        </div>
                        <span class="fw-bolder text-dark fs-5">{{ $unassessedCount }}</span>
                    </div>
                    <hr class="text-muted opacity-25">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center me-3" style="width:40px;height:40px;">
                                <i class="bi bi-trophy-fill text-info"></i>
                            </div>
                            <span class="text-muted fw-semibold">Rata-Rata Nilai Diberikan</span>
                        </div>
                        <span class="fw-bolder fs-4 {{ ($avgScore ?? 0) >= 70 ? 'text-success' : 'text-warning' }}">{{ $avgScore ? number_format($avgScore, 1) : '—' }}</span>
                    </div>

                    {{-- Progress bar visual --}}
                    @if($totalSchedules > 0)
                    <div class="mt-4 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted fw-semibold">Progress Penilaian</small>
                            <small class="fw-bold text-dark">{{ $totalAssessed }}/{{ $totalSchedules }}</small>
                        </div>
                        <div class="progress rounded-pill" style="height: 10px;">
                            @php $pct = $totalSchedules > 0 ? round(($totalAssessed / $totalSchedules) * 100) : 0; @endphp
                            <div class="progress-bar rounded-pill" role="progressbar" style="width: {{ $pct }}%; background: linear-gradient(90deg, #FFC837, #F5A623);" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection