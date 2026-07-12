@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bolder text-dark mb-1">Manajemen Pengguna</h3>
            <p class="text-muted mb-0">Kelola akun, hak akses, dan data seluruh pengguna sistem.</p>
        </div>
        <button class="btn fw-bold px-4 rounded-pill shadow-sm text-dark" style="background: linear-gradient(135deg, #FFC837, #F5A623); border: none;" data-bs-toggle="modal" data-bs-target="#tambahPenggunaModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna Baru
        </button>
    </div>


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Nama Pengguna</th>
                            <th class="py-3">Email Kampus</th>
                            <th class="py-3">Role Akses</th>
                            <th class="pe-4 py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    @php $colors = ['admin'=>'danger','dosen'=>'success','mahasiswa'=>'primary']; @endphp
                                    <div class="bg-{{ $colors[$user->role] ?? 'secondary' }} text-white rounded-circle d-flex justify-content-center align-items-center fw-bold me-3 shadow-sm" style="width:42px;height:42px;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->nim_nip ? ($user->role==='mahasiswa'?'NIM: ':'NIDN: ').$user->nim_nip : '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                @php $badgeColors = ['admin'=>'danger','dosen'=>'warning text-dark','mahasiswa'=>'secondary']; @endphp
                                <span class="badge bg-{{ $badgeColors[$user->role] ?? 'secondary' }} rounded-pill px-3 py-2 text-uppercase fw-semibold">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-light border text-primary rounded-pill px-3 fw-bold me-1" data-bs-toggle="modal" data-bs-target="#editPenggunaModal{{ $user->id }}"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn btn-sm btn-light border text-danger rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#hapusPenggunaModal{{ $user->id }}"><i class="bi bi-trash3"></i></button>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="editPenggunaModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-dark">Edit Data Pengguna</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <form action="{{ route('admin.pengguna.update', $user) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small text-dark">Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control focus-ring focus-ring-warning" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small text-dark">Email Kampus</label>
                                                <input type="email" name="email" class="form-control focus-ring focus-ring-warning" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label fw-semibold small text-dark">Role (Akses)</label>
                                                <select name="role" class="form-select focus-ring focus-ring-warning" required>
                                                    <option value="mahasiswa" {{ $user->role==='mahasiswa'?'selected':'' }}>Mahasiswa</option>
                                                    <option value="dosen" {{ $user->role==='dosen'?'selected':'' }}>Dosen</option>
                                                    <option value="admin" {{ $user->role==='admin'?'selected':'' }}>Admin TU</option>
                                                </select>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Perbarui Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Hapus --}}
                        <div class="modal fade" id="hapusPenggunaModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content border-0 shadow rounded-4 text-center p-4">
                                    <div class="text-danger mb-3"><i class="bi bi-exclamation-triangle-fill" style="font-size:3.5rem;"></i></div>
                                    <h5 class="fw-bold text-dark mb-2">Hapus Pengguna?</h5>
                                    <p class="text-muted small mb-4">Hapus akun <strong>{{ $user->name }}</strong>? Tindakan ini tidak bisa dibatalkan.</p>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Ya, Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada pengguna terdaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 border-top">
            <span class="text-muted small">Total {{ $users->count() }} pengguna.</span>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="tambahPenggunaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.pengguna.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control focus-ring focus-ring-warning" required placeholder="Masukkan nama...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Email Kampus</label>
                        <input type="email" name="email" class="form-control focus-ring focus-ring-warning" required placeholder="user@pnc.ac.id">
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Role (Akses)</label>
                            <select name="role" class="form-select focus-ring focus-ring-warning" required>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="admin">Admin TU</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-dark">Password Default</label>
                            <input type="text" class="form-control focus-ring focus-ring-warning bg-light" value="password" readonly>
                            <div class="form-text" style="font-size:0.7rem;">Password bawaan saat akun dibuat.</div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-gold py-2 rounded-pill fw-bold text-dark">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection