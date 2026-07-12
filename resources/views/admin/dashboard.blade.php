@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    
    <div class="mb-4">
        <h3 class="fw-bolder text-dark">Halo, {{ Auth::user()->name }}! 👋</h3>
        <p class="text-muted">Selamat datang di Panel Admin SEMAR. Berikut adalah ringkasan aktivitas akademik hari ini.</p>
    </div>


    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white hover-up h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-folder2-open text-primary fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Total Pengajuan</h6>
                        <h4 class="fw-bolder text-dark mb-0">{{ $totalSubmissions }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white hover-up h-100 border-start border-warning border-4">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-shield-exclamation text-warning fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Menunggu Verifikasi</h6>
                        <h4 class="fw-bolder text-dark mb-0">{{ $pendingCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white hover-up h-100 border-start border-success border-4">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-calendar-check text-success fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Sidang Terjadwal</h6>
                        <h4 class="fw-bolder text-dark mb-0">{{ $scheduledCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white hover-up h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-check2-all text-info fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-semibold mb-1 small text-uppercase">Selesai Dinilai</h6>
                        <h4 class="fw-bolder text-dark mb-0">{{ $assessedCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-dark mb-0"><i class="bi bi-lightning-charge-fill text-gold me-2"></i> Akses Cepat</h6>
        </div>
        <div class="card-body p-4">
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('admin.verifikasi') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="bi bi-shield-check me-1"></i> Verifikasi Berkas ({{ $pendingCount }})
                </a>
                <a href="{{ route('admin.jadwal') }}" class="btn btn-outline-success rounded-pill px-4 fw-bold shadow-sm">
                    <i class="bi bi-calendar-plus me-1"></i> Buat Jadwal Baru
                </a>
                <a href="{{ route('admin.pengguna') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="bi bi-people me-1"></i> Kelola Pengguna
                </a>
                <a href="{{ route('admin.rekapitulasi') }}" class="btn btn-outline-warning rounded-pill px-4 fw-bold shadow-sm">
                    <i class="bi bi-table me-1"></i> Rekapitulasi Nilai
                </a>
            </div>
        </div>
    </div>

    {{-- Statistik Detail --}}
    <div class="row g-4 mb-4">
        {{-- Pengajuan per Jenis --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Pengajuan per Jenis</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-semibold small">Seminar Proposal</span>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold">{{ $typeCounts['sempro'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-semibold small">Seminar Hasil</span>
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3 py-2 fw-bold">{{ $typeCounts['semhas'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fw-semibold small">Tugas Akhir</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-bold">{{ $typeCounts['ta'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Pengajuan --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-bar-chart-fill text-warning me-2"></i>Distribusi Status</h6>
                </div>
                <div class="card-body p-4">
                    @php
                        $statusItems = [
                            ['label' => 'Pending', 'count' => $statusCounts['pending'], 'color' => 'warning'],
                            ['label' => 'Terverifikasi', 'count' => $statusCounts['terverifikasi'], 'color' => 'success'],
                            ['label' => 'Dijadwalkan', 'count' => $statusCounts['dijadwalkan'], 'color' => 'primary'],
                            ['label' => 'Lulus', 'count' => $statusCounts['lulus'], 'color' => 'success'],
                            ['label' => 'Revisi TU', 'count' => $statusCounts['revisi_tu'], 'color' => 'danger'],
                        ];
                    @endphp
                    @foreach($statusItems as $item)
                    <div class="d-flex justify-content-between align-items-center {{ !$loop->last ? 'mb-2' : '' }}">
                        <span class="text-muted fw-semibold small">{{ $item['label'] }}</span>
                        <span class="badge bg-{{ $item['color'] }} bg-opacity-10 text-{{ $item['color'] }} rounded-pill px-3 py-1 fw-bold">{{ $item['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Pengguna per Role --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-people-fill text-success me-2"></i>Pengguna Terdaftar</h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width:30px;height:30px;font-size:0.75rem;">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <span class="text-muted fw-semibold small">Mahasiswa</span>
                        </div>
                        <span class="fw-bolder text-dark">{{ $userCounts['mahasiswa'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width:30px;height:30px;font-size:0.75rem;">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <span class="text-muted fw-semibold small">Dosen</span>
                        </div>
                        <span class="fw-bolder text-dark">{{ $userCounts['dosen'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width:30px;height:30px;font-size:0.75rem;">
                                <i class="bi bi-shield-fill"></i>
                            </div>
                            <span class="text-muted fw-semibold small">Admin</span>
                        </div>
                        <span class="fw-bolder text-dark">{{ $userCounts['admin'] }}</span>
                    </div>
                    <hr class="text-muted opacity-25 my-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark small">Total Pengguna</span>
                        <span class="fw-bolder text-dark fs-5">{{ $userCounts['mahasiswa'] + $userCounts['dosen'] + $userCounts['admin'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0">Perlu Verifikasi Segera</h6>
                    <a href="{{ route('admin.verifikasi') }}" class="text-decoration-none small fw-bold text-gold">Lihat Semua <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="card-body p-0">
                    @if($pendingSubmissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Mahasiswa</th>
                                    <th class="py-3">Jenis</th>
                                    <th class="py-3 text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingSubmissions as $sub)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark">{{ $sub->student->name }}</div>
                                        <div class="text-muted small">{{ $sub->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td>
                                        @php $badgeClass = match($sub->type) { 'ta' => 'primary', 'semhas' => 'info', 'sempro' => 'success', default => 'secondary' }; @endphp
                                        <span class="badge bg-{{ $badgeClass }} bg-opacity-10 text-{{ $badgeClass }} rounded-pill px-2">
                                            {{ $sub->type === 'ta' ? 'Tugas Akhir' : ($sub->type === 'semhas' ? 'Seminar Hasil' : 'Seminar Proposal') }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.verifikasi') }}" class="btn btn-sm btn-light border text-primary rounded-pill px-3 fw-bold">Cek</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-check-circle fs-1 text-success opacity-50"></i>
                        <p class="mt-2 mb-0">Semua pengajuan sudah diverifikasi! 🎉</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0">Sidang Terdekat</h6>
                    <a href="{{ route('admin.jadwal') }}" class="text-decoration-none small fw-bold text-gold">Kelola <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="card-body p-4">
                    @forelse($upcomingSchedules as $sch)
                    <div class="d-flex align-items-start {{ !$loop->last ? 'mb-4' : '' }}">
                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 text-center me-3" style="min-width: 60px;">
                            <div class="fw-bolder fs-5 lh-1 mb-1">{{ \Carbon\Carbon::parse($sch->date)->format('d') }}</div>
                            <div class="small fw-bold text-uppercase">{{ \Carbon\Carbon::parse($sch->date)->translatedFormat('M') }}</div>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">{{ $sch->submission->student->name }} ({{ $sch->submission->type === 'ta' ? 'Tugas Akhir' : ($sch->submission->type === 'semhas' ? 'Semhas' : 'Sempro') }})</h6>
                            <p class="text-muted small mb-0"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($sch->time_start)->format('H:i') }} WIB &bull; <i class="bi bi-geo-alt ms-1 me-1"></i> {{ $sch->room }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-calendar-x fs-1 opacity-50"></i>
                        <p class="mt-2 mb-0">Belum ada jadwal sidang mendatang.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection