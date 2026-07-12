@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4">
        <a href="{{ route('dosen.jadwal') }}" class="text-decoration-none text-muted fw-bold mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali ke Jadwal</a>
        <h3 class="fw-bolder text-dark">Form Penilaian Sidang</h3>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center fw-bold mx-auto mb-3 fs-3" style="width: 80px; height: 80px;">{{ strtoupper(substr($schedule->submission->student->name, 0, 1)) }}</div>
                    <h5 class="fw-bold text-dark mb-0">{{ $schedule->submission->student->name }}</h5>
                    <p class="text-muted small mb-0">NIM: {{ $schedule->submission->student->nim_nip ?? '-' }}</p>
                    @php $bc = match($schedule->submission->type) { 'ta'=>'primary','semhas'=>'info','sempro'=>'success',default=>'secondary' }; @endphp
                    <span class="badge bg-{{ $bc }} bg-opacity-10 text-{{ $bc }} border border-{{ $bc }} rounded-pill px-3 mt-2">
                        {{ $schedule->submission->type === 'ta' ? 'Sidang Tugas Akhir' : ($schedule->submission->type === 'semhas' ? 'Seminar Hasil' : 'Seminar Proposal') }}
                    </span>
                </div>
                <hr class="text-muted opacity-25">
                <p class="text-muted small fw-bold mb-1">Judul Penelitian:</p>
                <p class="text-dark fw-semibold small">{{ $schedule->submission->title }}</p>
                <a href="{{ route('documents.show', $schedule->submission->document_path) }}" target="_blank" class="btn btn-outline-danger w-100 rounded-pill fw-bold btn-sm mt-2"><i class="bi bi-file-earmark-pdf-fill me-1"></i> Buka Laporan PDF</a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-ui-checks-grid text-warning me-2"></i> Input Komponen Nilai (0 - 100)</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if($assessment && $assessment->is_locked)
                    <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-dark rounded-3 mb-4">
                        <i class="bi bi-lock-fill me-2"></i> <strong>Nilai sudah dikunci secara permanen.</strong> Anda tidak dapat mengubah nilai ini.
                    </div>
                    @endif

                    <form action="{{ route('dosen.penilaian.store', $schedule) }}" method="POST">
                        @csrf
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark">Nilai Presentasi</label>
                                <input type="number" class="form-control border-2 shadow-none focus-ring focus-ring-warning form-control-lg" name="score_presentation" min="0" max="100" placeholder="0" value="{{ $assessment->score_presentation ?? '' }}" required {{ $assessment && $assessment->is_locked ? 'readonly' : '' }}>
                                <div class="form-text small">Sikap, penyampaian, dan media.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark">Nilai Materi Laporan</label>
                                <input type="number" class="form-control border-2 shadow-none focus-ring focus-ring-warning form-control-lg" name="score_material" min="0" max="100" placeholder="0" value="{{ $assessment->score_material ?? '' }}" required {{ $assessment && $assessment->is_locked ? 'readonly' : '' }}>
                                <div class="form-text small">Substansi, penulisan, kesimpulan.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-dark">Nilai Tanya Jawab (QnA)</label>
                                <input type="number" class="form-control border-2 shadow-none focus-ring focus-ring-warning form-control-lg" name="score_qna" min="0" max="100" placeholder="0" value="{{ $assessment->score_qna ?? '' }}" required {{ $assessment && $assessment->is_locked ? 'readonly' : '' }}>
                                <div class="form-text small">Penguasaan materi & argumen.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Catatan Revisi untuk Mahasiswa</label>
                            <textarea class="form-control border-2 shadow-none focus-ring focus-ring-warning" name="revision_notes" rows="4" placeholder="Tuliskan masukan dan bagian mana saja yang harus direvisi oleh mahasiswa..." {{ $assessment && $assessment->is_locked ? 'readonly' : '' }}>{{ $assessment->revision_notes ?? '' }}</textarea>
                        </div>

                        @if(!$assessment || !$assessment->is_locked)
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="lockScore" name="is_locked">
                                <label class="form-check-label fw-bold text-danger ms-2" for="lockScore">Kunci Nilai Permanen</label>
                            </div>
                            <button type="submit" class="btn btn-gold px-5 py-2 rounded-pill fw-bold shadow-sm">
                                Simpan Nilai <i class="bi bi-save-fill ms-2"></i>
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection