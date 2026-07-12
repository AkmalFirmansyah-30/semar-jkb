@extends('layouts.app')

@section('content')
<div class="container py-4 mt-3">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">


            <div class="text-center mb-4">
                <h2 class="fw-bolder text-dark mt-2">Form Pengajuan Sidang</h2>
                <p class="text-muted">Sistem Manajemen Seminar dan Sidang JKB</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="card-header text-center py-3" style="background: linear-gradient(135deg, #FFC837, #F5A623); border-bottom: none;">
                    <span class="fw-bold text-dark"><i class="bi bi-file-earmark-arrow-up me-2"></i> Masukkan Data Pengajuan Dokumen</span>
                </div>
                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Jenis Sidang</label>
                            <select class="form-select border-2 shadow-none focus-ring focus-ring-warning" name="type" required>
                                <option value="" selected disabled>-- Pilih Jenis Sidang --</option>
                                <option value="sempro">Seminar Proposal</option>
                                <option value="semhas">Seminar Hasil</option>
                                <option value="ta">Sidang Tugas Akhir</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Dosen Pembimbing</label>
                            <select class="form-select border-2 shadow-none focus-ring focus-ring-warning" name="supervisor_id" required>
                                <option value="" selected disabled>-- Pilih Dosen Pembimbing --</option>
                                @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Judul Penelitian</label>
                            <textarea class="form-control border-2 shadow-none focus-ring focus-ring-warning" name="title" rows="3" placeholder="Ketik judul lengkap laporan/penelitian Anda di sini..." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Upload Draf Laporan (PDF)</label>
                            <input class="form-control border-2 shadow-none focus-ring focus-ring-warning" type="file" name="document" accept=".pdf" required>
                            <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Maksimal ukuran file 5MB.</div>
                        </div>
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn fw-bold rounded-pill py-3 shadow-sm" style="background: linear-gradient(135deg, #FFC837, #F5A623); color: #121212; border: none;">
                                Kirim Pengajuan <i class="bi bi-send-fill ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($submissions->count() > 0)
            <h4 class="fw-bolder text-dark mb-3"><i class="bi bi-clock-history text-warning me-2"></i>Riwayat Pengajuan Anda</h4>
            @foreach($submissions as $sub)
            <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">{{ $sub->title }}</h6>
                            <p class="text-muted small mb-2">
                                {{ $sub->type === 'ta' ? 'Tugas Akhir' : ($sub->type === 'semhas' ? 'Seminar Hasil' : 'Seminar Proposal') }}
                                &bull; Pembimbing: {{ $sub->supervisor->name ?? '-' }}
                                &bull; {{ $sub->created_at->translatedFormat('d M Y H:i') }}
                            </p>
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-warning bg-opacity-10 text-warning border-warning',
                                    'revisi_tu' => 'bg-danger bg-opacity-10 text-danger border-danger',
                                    'terverifikasi' => 'bg-success bg-opacity-10 text-success border-success',
                                    'dijadwalkan' => 'bg-primary bg-opacity-10 text-primary border-primary',
                                    'revisi_dosen' => 'bg-info bg-opacity-10 text-info border-info',
                                    'lulus' => 'bg-success bg-opacity-10 text-success border-success',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Verifikasi',
                                    'revisi_tu' => 'Ditolak - Perlu Revisi',
                                    'terverifikasi' => 'Diterima',
                                    'dijadwalkan' => 'Dijadwalkan',
                                    'revisi_dosen' => 'Revisi Dosen',
                                    'lulus' => 'Lulus',
                                ];
                            @endphp
                            <span class="badge {{ $statusStyles[$sub->status] ?? '' }} border rounded-pill px-3 py-2 fw-semibold">
                                {{ $statusLabels[$sub->status] ?? $sub->status }}
                            </span>
                            @if($sub->status === 'revisi_tu' && $sub->admin_notes)
                            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 small mt-3 mb-0 rounded-3">
                                <i class="bi bi-exclamation-circle-fill me-1"></i> <strong>Catatan Admin:</strong> {{ $sub->admin_notes }}
                            </div>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            @if($sub->status === 'revisi_tu')
                            <button class="btn btn-sm btn-warning rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#editSubmission{{ $sub->id }}">
                                <i class="bi bi-pencil-square me-1"></i> Perbaiki
                            </button>
                            @endif
                            @if($sub->status === 'pending')
                            <form action="{{ route('mahasiswa.pengajuan.destroy', $sub) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">
                                    <i class="bi bi-trash3 me-1"></i> Batalkan
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($sub->status === 'revisi_tu')
            <div class="modal fade" id="editSubmission{{ $sub->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow rounded-4">
                        <div class="modal-header border-bottom-0 pb-0">
                            <h5 class="modal-title fw-bold text-dark">Perbaiki Pengajuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{ route('mahasiswa.pengajuan.update', $sub) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Judul Penelitian</label>
                                    <textarea name="title" class="form-control focus-ring focus-ring-warning" rows="3" required>{{ $sub->title }}</textarea>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-semibold small text-dark d-block">Upload Ulang Draf (PDF)</label>
                                    
                                    @if($sub->document_path)
                                    <a href="{{ route('documents.show', $sub->document_path) }}" target="_blank" class="badge bg-light text-danger border border-danger-subtle text-decoration-none mb-3 px-3 py-2">
                                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Lihat File PDF Saat Ini
                                    </a>
                                    @endif
                                    
                                    <input type="file" name="document" class="form-control focus-ring focus-ring-warning" accept=".pdf">
                                    <div class="form-text small">Kosongkan/abaikan input ini jika Anda hanya ingin merevisi judul penelitian.</div>
                                </div>
                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold text-dark">Kirim Ulang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif

        </div>
    </div>
</div>
@endsection