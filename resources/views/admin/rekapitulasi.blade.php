@extends('layouts.app')

@section('content')
{{-- CSS khusus untuk mode cetak --}}
<style>
    @media print {
        /* Sembunyikan elemen navigasi & sidebar */
        nav, .sidebar, .navbar, #sidebar, .no-print, .card-footer {
            display: none !important;
        }
        /* Buat konten full-width */
        .main-content, .container-fluid, [class*="col-"] {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        body {
            background: white !important;
            font-size: 11pt !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .table th, .table td {
            padding: 6px 8px !important;
            font-size: 10pt !important;
        }
        .badge {
            border: 1px solid #333 !important;
            color: #333 !important;
            background: transparent !important;
        }
        /* Header cetak */
        .print-header {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px double #333;
        }
        /* Expandable detail rows tetap tampil saat cetak */
        .bg-light { background-color: #f8f9fa !important; }
    }
    .print-header { display: none; }
</style>

<div class="container-fluid px-0">

    {{-- Header cetak (hanya muncul saat print) --}}
    <div class="print-header">
        <h3 class="fw-bolder mb-1">BERITA ACARA PENILAIAN SIDANG</h3>
        <p class="text-muted mb-1">Sistem SEMAR JKB — Rekapitulasi Nilai Sidang Mahasiswa</p>
        <small class="text-muted">Dicetak pada: {{ now()->translatedFormat('l, d F Y — H:i') }} WIB</small>
    </div>

    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bolder text-dark mb-1">Rekapitulasi Nilai Sidang</h3>
            <p class="text-muted mb-0">Tabel lengkap seluruh hasil penilaian sidang mahasiswa.</p>
        </div>
        <div class="no-print">
            <button onclick="window.print()" class="btn fw-bold px-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #FFC837, #F5A623); color: #121212; border: none;">
                <i class="bi bi-printer-fill me-2"></i> Cetak Rekapitulasi
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            @if($schedules->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Mahasiswa</th>
                            <th class="py-3">Jenis</th>
                            <th class="py-3">Judul Penelitian</th>
                            <th class="py-3 text-center">Penguji 1</th>
                            <th class="py-3 text-center">Penguji 2</th>
                            <th class="py-3 text-center">Rata-Rata</th>
                            <th class="pe-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $idx => $sch)
                        @php
                            $a1 = $sch->assessments->where('examiner_id', $sch->examiner_1_id)->first();
                            $a2 = $sch->assessments->where('examiner_id', $sch->examiner_2_id)->first();
                            $avg = null;
                            if ($a1 && $a2 && $a1->is_locked && $a2->is_locked) {
                                $avg = round(($a1->total_score + $a2->total_score) / 2, 2);
                            }
                        @endphp
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-muted">{{ $idx + 1 }}</td>
                            <td class="py-3">
                                <div class="fw-bold text-dark">{{ $sch->submission->student->name }}</div>
                                <div class="text-muted small">{{ $sch->submission->student->nim_nip ?? '-' }}</div>
                            </td>
                            <td>
                                @php $bc = match($sch->submission->type) { 'ta'=>'primary','semhas'=>'info','sempro'=>'success',default=>'secondary' }; @endphp
                                <span class="badge bg-{{ $bc }} bg-opacity-10 text-{{ $bc }} border border-{{ $bc }} rounded-pill px-2 py-1">
                                    {{ $sch->submission->type === 'ta' ? 'TA' : ($sch->submission->type === 'semhas' ? 'Semhas' : 'Sempro') }}
                                </span>
                            </td>
                            <td style="max-width: 220px;">
                                <div class="text-truncate" title="{{ $sch->submission->title }}">{{ $sch->submission->title }}</div>
                            </td>
                            <td class="text-center">
                                @if($a1)
                                    <div class="fw-bold {{ $a1->is_locked ? 'text-dark' : 'text-warning' }}">{{ $a1->total_score }}</div>
                                    <div class="text-muted small">{{ $sch->examiner1->name }}</div>
                                    @if($a1->is_locked)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2" style="font-size:0.65rem;"><i class="bi bi-lock-fill"></i> Dikunci</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2" style="font-size:0.65rem;">Draft</span>
                                    @endif
                                @else
                                    <span class="text-muted small">—</span>
                                    <div class="text-muted small">{{ $sch->examiner1->name }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($a2)
                                    <div class="fw-bold {{ $a2->is_locked ? 'text-dark' : 'text-warning' }}">{{ $a2->total_score }}</div>
                                    <div class="text-muted small">{{ $sch->examiner2->name }}</div>
                                    @if($a2->is_locked)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2" style="font-size:0.65rem;"><i class="bi bi-lock-fill"></i> Dikunci</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2" style="font-size:0.65rem;">Draft</span>
                                    @endif
                                @else
                                    <span class="text-muted small">—</span>
                                    <div class="text-muted small">{{ $sch->examiner2->name }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($avg !== null)
                                    <span class="fw-bolder fs-5 {{ $avg >= 70 ? 'text-success' : ($avg >= 50 ? 'text-warning' : 'text-danger') }}">{{ $avg }}</span>
                                @else
                                    <span class="text-muted small fst-italic">Belum lengkap</span>
                                @endif
                            </td>
                            <td class="pe-4 text-center">
                                @if($avg !== null)
                                    @if($avg >= 70)
                                        <span class="badge bg-success rounded-pill px-3 py-2 fw-bold">LULUS</span>
                                    @elseif($avg >= 50)
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold">REVISI</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold">TIDAK LULUS</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2 fw-semibold">Proses</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Detail Komponen Nilai (Expandable Row) --}}
                        @if($a1 || $a2)
                        <tr class="bg-light">
                            <td></td>
                            <td colspan="7" class="py-2 px-4">
                                <div class="row g-3 small">
                                    @if($a1)
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-bold text-dark"><i class="bi bi-person-fill me-1"></i>{{ $sch->examiner1->name }} (Penguji 1)</span>
                                            {{-- Tombol Reset Nilai Penguji 1 --}}
                                            <form action="{{ route('admin.penilaian.destroy', $a1) }}" method="POST" class="no-print d-inline" onsubmit="return confirm('Yakin ingin mereset nilai dari {{ $sch->examiner1->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-0" style="font-size: 0.7rem;" title="Reset nilai penguji 1">
                                                    <i class="bi bi-trash3 me-1"></i>Reset
                                                </button>
                                            </form>
                                        </div>
                                        <div class="d-flex gap-3 text-muted">
                                            <span>Presentasi: <strong class="text-dark">{{ $a1->score_presentation }}</strong></span>
                                            <span>Materi: <strong class="text-dark">{{ $a1->score_material }}</strong></span>
                                            <span>QnA: <strong class="text-dark">{{ $a1->score_qna }}</strong></span>
                                            <span>Total: <strong class="text-primary">{{ $a1->total_score }}</strong></span>
                                        </div>
                                        @if($a1->revision_notes)
                                        <div class="text-muted mt-1"><i class="bi bi-chat-left-text me-1"></i>{{ $a1->revision_notes }}</div>
                                        @endif
                                    </div>
                                    @endif
                                    @if($a2)
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-bold text-dark"><i class="bi bi-person-fill me-1"></i>{{ $sch->examiner2->name }} (Penguji 2)</span>
                                            {{-- Tombol Reset Nilai Penguji 2 --}}
                                            <form action="{{ route('admin.penilaian.destroy', $a2) }}" method="POST" class="no-print d-inline" onsubmit="return confirm('Yakin ingin mereset nilai dari {{ $sch->examiner2->name }}? Tindakan ini tidak dapat dibatalkan.')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-0" style="font-size: 0.7rem;" title="Reset nilai penguji 2">
                                                    <i class="bi bi-trash3 me-1"></i>Reset
                                                </button>
                                            </form>
                                        </div>
                                        <div class="d-flex gap-3 text-muted">
                                            <span>Presentasi: <strong class="text-dark">{{ $a2->score_presentation }}</strong></span>
                                            <span>Materi: <strong class="text-dark">{{ $a2->score_material }}</strong></span>
                                            <span>QnA: <strong class="text-dark">{{ $a2->score_qna }}</strong></span>
                                            <span>Total: <strong class="text-primary">{{ $a2->total_score }}</strong></span>
                                        </div>
                                        @if($a2->revision_notes)
                                        <div class="text-muted mt-1"><i class="bi bi-chat-left-text me-1"></i>{{ $a2->revision_notes }}</div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-clipboard-data text-secondary" style="font-size:4rem;opacity:0.4;"></i>
                <h5 class="fw-bold text-dark mt-3">Belum Ada Data Penilaian</h5>
                <p class="text-muted">Buat jadwal sidang dan minta dosen menilai terlebih dahulu.</p>
            </div>
            @endif
        </div>
        <div class="card-footer bg-white py-3 border-top">
            <span class="text-muted small">Total {{ $schedules->count() }} jadwal sidang.</span>
        </div>
    </div>
</div>
@endsection
