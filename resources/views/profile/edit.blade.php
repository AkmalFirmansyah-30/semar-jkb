@extends('layouts.app')

@section('content')
<style>
    .btn-oren-semar {
        background: linear-gradient(135deg, #FFC837, #F5A623);
        color: #ffffff !important;
        border: none;
        box-shadow: 0 4px 10px rgba(245, 166, 35, 0.3);
        transition: all 0.3s ease;
    }
    .btn-oren-semar:hover {
        background: linear-gradient(135deg, #F5A623, #e09412);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(245, 166, 35, 0.4);
    }
    .btn-camera-semar {
        background-color: #F5A623;
        color: white !important;
    }
    .btn-camera-semar:hover {
        background-color: #e09412;
    }
</style>

<div class="container-fluid px-0">
    
    <div class="mb-4">
        <h3 class="fw-bolder text-dark mb-1">Akun Saya</h3>
        <p class="text-muted">Perbarui informasi profil dan amankan akun Anda secara berkala.</p>
    </div>

    <div class="row g-4 align-items-stretch">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 text-center h-100 d-flex flex-column">
                
                <div class="mb-4 pt-2">
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <div class="rounded-circle d-flex justify-content-center align-items-center bg-light border border-2 shadow-sm overflow-hidden" style="width: 120px; height: 120px;">
                            @if(Auth::user()->avatar)
                                <img id="avatarPreview" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i id="avatarIcon" class="bi bi-person-fill text-secondary" style="font-size: 4rem;"></i>
                                <img id="avatarPreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                            @endif
                        </div>
                        <label for="upload-avatar" class="btn btn-camera-semar btn-sm position-absolute bottom-0 end-0 rounded-circle border-white border-2 d-flex justify-content-center align-items-center" style="width: 35px; height: 35px; cursor: pointer;" title="Ganti Foto">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                    </div>
                    <h4 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h4>
                    <p class="text-uppercase fw-bold text-muted small mb-0" style="letter-spacing: 0.1em;">{{ Auth::user()->role }}</p>
                </div>
                
                <div class="bg-light rounded-4 p-4 text-start flex-grow-1 d-flex flex-column justify-content-center">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-info-circle-fill text-gold me-2"></i>Detail Informasi</h6>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.65rem;">Nomor Induk (NIM/NIDN)</small>
                        <div class="d-flex align-items-center mt-1">
                            <i class="bi bi-person-badge text-secondary me-2"></i>
                            <span class="text-dark fw-bold small">{{ Auth::user()->nim_nip ?? '-' }}</span> 
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.65rem;">Program Studi</small>
                        <div class="d-flex align-items-center mt-1">
                            <i class="bi bi-building text-secondary me-2"></i>
                            <span class="text-dark fw-bold small">{{ Auth::user()->prodi ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.65rem;">Email Kampus</small>
                        <div class="d-flex align-items-center mt-1">
                            <i class="bi bi-envelope-at text-secondary me-2"></i>
                            <span class="text-dark fw-bold small">{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    <div class="mb-0 mt-auto pt-3 border-top">
                        <small class="text-muted d-block fw-semibold text-uppercase mb-2" style="font-size: 0.65rem;">Status Akun</small>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Aktif Terverifikasi</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-8 d-flex flex-column gap-4">
            
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-vcard text-gold me-2"></i> Informasi Pribadi</h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        
                        <input type="file" name="avatar" id="upload-avatar" class="d-none" accept="image/jpeg, image/png, image/jpg">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-3 border-2 focus-ring focus-ring-warning" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Alamat Email</label>
                                <input type="email" name="email" class="form-control rounded-3 border-2 focus-ring focus-ring-warning" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>
                            
                            <div class="col-md-6 mt-2">
                                <label class="form-label fw-bold small">Nomor Induk (NIM / NIDN)</label>
                                <input type="text" name="nim_nip" class="form-control rounded-3 border-2 focus-ring focus-ring-warning" value="{{ old('nim_nip', Auth::user()->nim_nip) }}" placeholder="Masukkan NIM atau NIDN">
                            </div>
                            
                            <div class="col-md-6 mt-2">
                                <label class="form-label fw-bold small">Program Studi</label>
                                <input type="text" name="prodi" class="form-control rounded-3 border-2 focus-ring focus-ring-warning" value="{{ old('prodi', Auth::user()->prodi) }}" placeholder="Contoh: D3 Teknik Informatika">
                            </div>
                            
                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-oren-semar fw-bold px-5 py-2 rounded-pill">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-white flex-grow-1">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-shield-lock text-gold me-2"></i> Keamanan Akun</h5>
                </div>
                <div class="card-body px-4 pb-4 pt-0">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold small">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control rounded-3 border-2 focus-ring focus-ring-warning" placeholder="Masukkan password lama">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Password Baru</label>
                                <input type="password" name="password" class="form-control rounded-3 border-2 focus-ring focus-ring-warning" placeholder="Minimal 8 karakter">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-3 border-2 focus-ring focus-ring-warning" placeholder="Ulangi password baru">
                            </div>
                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-oren-semar fw-bold px-5 py-2 rounded-pill">Perbarui Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@vite('resources/js/profile.js')
@endsection