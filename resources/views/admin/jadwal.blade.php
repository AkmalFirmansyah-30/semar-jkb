@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bolder text-dark mb-1">Manajemen Jadwal Sidang</h3>
            <p class="text-muted mb-0">Atur tanggal, ruangan, dan ploting dosen penguji untuk mahasiswa.</p>
        </div>
        <button class="btn fw-bold px-4 rounded-pill shadow-sm text-dark" style="background: linear-gradient(135deg, #FFC837, #F5A623); border: none;" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">
            <i class="bi bi-calendar-plus-fill me-1"></i> Buat Jadwal Baru
        </button>
    </div>


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            @if($schedules->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Waktu & Tempat</th>
                            <th class="py-3">Mahasiswa & Judul</th>
                            <th class="py-3">Tim Penguji</th>
                            <th class="pe-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $sch)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark"><i class="bi bi-calendar-event text-warning me-1"></i> {{ \Carbon\Carbon::parse($sch->date)->translatedFormat('d M Y') }}</div>
                                <div class="text-muted small"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($sch->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($sch->time_end)->format('H:i') }} WIB</div>
                                <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i> {{ $sch->room }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $sch->submission->student->name }}</div>
                                @php $bc = match($sch->submission->type) { 'ta'=>'primary','semhas'=>'info','sempro'=>'success',default=>'secondary' }; @endphp
                                <span class="badge bg-{{ $bc }} bg-opacity-10 text-{{ $bc }} border border-{{ $bc }} rounded-pill px-2 py-1">{{ $sch->submission->type === 'ta' ? 'Tugas Akhir' : ($sch->submission->type === 'semhas' ? 'Sem. Hasil' : 'Sem. Proposal') }}</span>
                            </td>
                            <td>
                                <div class="text-dark small mb-1"><span class="fw-bold badge bg-secondary rounded-circle px-2 py-1 me-1">1</span> {{ $sch->examiner1->name }}</div>
                                <div class="text-dark small"><span class="fw-bold badge bg-secondary rounded-circle px-2 py-1 me-1">2</span> {{ $sch->examiner2->name }}</div>
                            </td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border text-primary rounded-pill px-3 fw-bold me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $sch->id }}"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm btn-light border text-danger rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $sch->id }}"><i class="bi bi-trash3"></i></button>
                            </td>
                        </tr>
                        {{-- Edit Modal --}}
                        <div class="modal fade" id="editModal{{ $sch->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square text-gold me-2"></i>Edit Jadwal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form action="{{ route('admin.jadwal.update', $sch) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="row g-3 mb-4">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold small">Tanggal</label>
                                                    <input type="date" name="date" class="form-control focus-ring focus-ring-warning" value="{{ $sch->date }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold small">Jam Mulai</label>
                                                    <input type="time" name="time_start" class="form-control focus-ring focus-ring-warning" value="{{ \Carbon\Carbon::parse($sch->time_start)->format('H:i') }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold small">Jam Selesai</label>
                                                    <input type="time" name="time_end" class="form-control focus-ring focus-ring-warning" value="{{ \Carbon\Carbon::parse($sch->time_end)->format('H:i') }}" required>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label fw-semibold small">Ruangan</label>
                                                    <input type="text" name="room" class="form-control focus-ring focus-ring-warning" value="{{ $sch->room }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Penguji 1</label>
                                                    <select name="examiner_1_id" class="form-select focus-ring focus-ring-warning" required>
                                                        @foreach($dosens as $d)
                                                        <option value="{{ $d->id }}" {{ $sch->examiner_1_id==$d->id?'selected':'' }}>{{ $d->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Penguji 2</label>
                                                    <select name="examiner_2_id" class="form-select focus-ring focus-ring-warning" required>
                                                        @foreach($dosens as $d)
                                                        <option value="{{ $d->id }}" {{ $sch->examiner_2_id==$d->id?'selected':'' }}>{{ $d->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-gold py-2 px-5 rounded-pill fw-bold text-dark shadow-sm">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Hapus Modal --}}
                        <div class="modal fade" id="hapusModal{{ $sch->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content border-0 shadow rounded-4 text-center p-4">
                                    <div class="text-danger mb-3"><i class="bi bi-calendar-x-fill" style="font-size:3.5rem;"></i></div>
                                    <h5 class="fw-bold text-dark mb-2">Batalkan Jadwal?</h5>
                                    <p class="text-muted small mb-4">Jadwal <strong>{{ $sch->submission->student->name }}</strong> akan dihapus.</p>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Tutup</button>
                                        <form action="{{ route('admin.jadwal.destroy', $sch) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Ya, Hapus</button>
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
                <i class="bi bi-calendar-x text-secondary" style="font-size:4rem;opacity:0.4;"></i>
                <h5 class="fw-bold text-dark mt-3">Belum Ada Jadwal</h5>
                <p class="text-muted">Klik "Buat Jadwal Baru" untuk memulai.</p>
            </div>
            @endif
        </div>
        <div class="card-footer bg-white py-3 border-top">
            <span class="text-muted small">Total {{ $schedules->count() }} jadwal.</span>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-calendar-plus text-gold me-2"></i>Buat Jadwal Sidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 p-md-5">
                <form action="{{ route('admin.jadwal.store') }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Pilih Pengajuan</label>
                            <select name="submission_id" class="form-select focus-ring focus-ring-warning" required>
                                <option value="" selected disabled>-- Pilih Mahasiswa --</option>
                                @foreach($approvedSubmissions as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->student->name }} - {{ $sub->type==='ta'?'TA':($sub->type==='semhas'?'Semhas':'Sempro') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Tanggal</label>
                            <input type="date" name="date" class="form-control focus-ring focus-ring-warning" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Jam Mulai</label>
                            <input type="time" name="time_start" class="form-control focus-ring focus-ring-warning" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Jam Selesai</label>
                            <input type="time" name="time_end" class="form-control focus-ring focus-ring-warning" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Ruangan</label>
                            <input type="text" name="room" class="form-control focus-ring focus-ring-warning" placeholder="Contoh: Ruang Sidang Utama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Dosen Penguji 1 (Ketua)</label>
                            <select name="examiner_1_id" class="form-select focus-ring focus-ring-warning" required>
                                <option value="" selected disabled>-- Pilih --</option>
                                @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Dosen Penguji 2 (Anggota)</label>
                            <select name="examiner_2_id" class="form-select focus-ring focus-ring-warning" required>
                                <option value="" selected disabled>-- Pilih --</option>
                                @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-gold py-2 px-5 rounded-pill fw-bold text-dark shadow-sm">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection