@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    
    <div class="mb-4">
        <h3 class="fw-bolder text-dark">Verifikasi Berkas Pengajuan</h3>
        <p class="text-muted">Periksa kelengkapan draf laporan mahasiswa sebelum dijadwalkan sidang.</p>
    </div>


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">Daftar Menunggu Verifikasi</h5>
            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">{{ $submissions->count() }} Menunggu</span>
        </div>
        
        <div class="card-body p-0">
            @if($submissions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Mahasiswa</th>
                            <th class="py-3">Jenis Sidang</th>
                            <th class="py-3">Judul Penelitian</th>
                            <th class="py-3 text-center">Dokumen</th>
                            <th class="pe-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $submission->student->name }}</div>
                                <div class="text-muted small">NIM: {{ $submission->student->nim_nip ?? '-' }}</div>
                            </td>
                            <td>
                                @php $badgeClass = match($submission->type) { 'ta' => 'primary', 'semhas' => 'info', 'sempro' => 'success', default => 'secondary' }; @endphp
                                <span class="badge bg-{{ $badgeClass }} bg-opacity-10 text-{{ $badgeClass }} border border-{{ $badgeClass }} rounded-pill px-2">
                                    {{ $submission->type === 'ta' ? 'Tugas Akhir' : ($submission->type === 'semhas' ? 'Seminar Hasil' : 'Seminar Proposal') }}
                                </span>
                            </td>
                            <td style="max-width: 250px;" class="text-truncate" title="{{ $submission->title }}">
                                {{ $submission->title }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('documents.show', $submission->document_path) }}" target="_blank" class="btn btn-sm btn-light border text-danger fw-bold rounded-pill px-3">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Lihat PDF
                                </a>
                            </td>
                            <td class="pe-4 text-end">
                                <form action="{{ route('admin.verifikasi.approve', $submission) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill shadow-sm me-1 px-3 fw-bold" title="Terima Berkas">
                                        <i class="bi bi-check-lg"></i> Terima
                                    </button>
                                </form>
                                <button class="btn btn-sm btn-danger rounded-pill shadow-sm px-3 fw-bold" title="Tolak / Revisi" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $submission->id }}">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Tolak per pengajuan --}}
                        <div class="modal fade" id="tolakModal{{ $submission->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-dark"><i class="bi bi-x-circle text-danger me-2"></i>Tolak Pengajuan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <p class="text-muted small">Berikan catatan alasan penolakan agar mahasiswa dapat memperbaiki pengajuannya.</p>
                                        <form action="{{ route('admin.verifikasi.reject', $submission) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="mb-4">
                                                <label class="form-label fw-semibold small text-dark">Catatan Penolakan</label>
                                                <textarea class="form-control focus-ring focus-ring-warning" name="admin_notes" rows="3" placeholder="Contoh: File PDF tidak bisa dibuka / Data tidak lengkap..." required></textarea>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Tolak Pengajuan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-check-circle text-success" style="font-size: 4rem; opacity: 0.5;"></i>
                <h5 class="fw-bold text-dark mt-3">Semua Beres!</h5>
                <p class="text-muted">Tidak ada pengajuan yang menunggu verifikasi saat ini.</p>
            </div>
            @endif
        </div>

        <div class="card-footer bg-white py-3 border-top">
            <span class="text-muted small">Menampilkan {{ $submissions->count() }} data pengajuan pending.</span>
        </div>
    </div>

</div>
@endsection