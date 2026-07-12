<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - SEMAR JKB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --gold-primary: #F5A623; --gold-secondary: #FFC837; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        .bg-gold-gradient { background: linear-gradient(135deg, var(--gold-secondary), #e09412); }
        .text-gold { color: var(--gold-primary) !important; }
        .btn-gold { background: linear-gradient(135deg, var(--gold-secondary), var(--gold-primary)); color: white; font-weight: 700; border: none; transition: all 0.3s ease; }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(245, 166, 35, 0.4); color: white; }
        .login-card { width: 100%; max-width: 450px; border: 1px solid rgba(0,0,0,0.05); border-radius: 1.2rem; box-shadow: 0 15px 35px rgba(0,0,0,0.08); position: relative; overflow: hidden; }
        .corner-blob { position: absolute; top: -25px; right: -25px; width: 80px; height: 80px; background: linear-gradient(135deg, var(--gold-secondary), var(--gold-primary)); border-radius: 50%; opacity: 0.9; }
        .input-group-text { background-color: transparent; border-right: none; color: #a0a0a0; padding-left: 1.2rem; }
        .form-control.custom-input { border-left: none; padding-left: 10px; box-shadow: none; font-size: 0.95rem; }
        .form-control.custom-input:focus { border-color: #dee2e6; }
        .input-group:focus-within { border-color: var(--gold-primary) !important; box-shadow: 0 0 0 0.25rem rgba(245, 166, 35, 0.15); }
        .input-group:focus-within .input-group-text, .input-group:focus-within .custom-input { color: var(--gold-primary); }
    </style>
</head>
<body>
<div class="container-fluid px-0">
    <div class="row g-0 min-vh-100">
        <div class="col-lg-6 d-none d-lg-flex bg-gold-gradient text-white flex-column justify-content-center align-items-center p-5 text-center">
            <img src="{{ asset('images/logo-gunungan.png') }}" alt="SEMAR Logo" class="mb-4" style="max-height: 220px; filter: brightness(0) invert(1);">
            <h1 class="fw-bolder display-5 mb-3">Welcome to Semar</h1>
            <p class="fs-6 px-xl-5 fw-medium lh-lg" style="opacity: 0.9; max-width: 550px;">Transformasi digital untuk simplifikasi birokrasi pendaftaran, penjadwalan, hingga penilaian Tugas Akhir di Jurusan Komputer dan Bisnis, Politeknik Negeri Cilacap</p>
        </div>

        <div class="col-lg-6 d-flex justify-content-center align-items-center bg-white p-4">
            <div class="login-card p-4 p-md-5 bg-white">
                <div class="corner-blob"></div>

                <div class="text-center mb-5 position-relative" style="z-index: 2;">
                    <h2 class="fw-bolder text-gold mb-1">Reset Password</h2>
                    <p class="text-muted small fw-semibold">Silahkan Reset Password Anda</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="position-relative" style="z-index: 2;">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Email</label>
                        <div class="input-group border rounded-3 overflow-hidden py-1">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control custom-input" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="Masukkan Email">
                        </div>
                        @error('email')<div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Password Baru</label>
                        <div class="input-group border rounded-3 overflow-hidden py-1">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control custom-input" name="password" required placeholder="Masukkan Password Baru">
                            <button type="button" class="input-group-text toggle-password-btn" style="cursor: pointer; padding-right: 1.2rem;"><i class="bi bi-eye"></i></button>
                        </div>
                        @error('password')<div class="text-danger mt-1 small"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Konfirmasi Password</label>
                        <div class="input-group border rounded-3 overflow-hidden py-1">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control custom-input" name="password_confirmation" required placeholder="Ulangi Password Baru">
                            <button type="button" class="input-group-text toggle-password-btn" style="cursor: pointer; padding-right: 1.2rem;"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-3 rounded-3 shadow-sm fs-6">Simpan Password Baru</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    });
</script>
</body>
</html>