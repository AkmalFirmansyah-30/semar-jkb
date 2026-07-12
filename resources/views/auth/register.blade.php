<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - SEMAR JKB</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --gold-primary: #F0A500; 
            --gold-secondary: #F8C330;
            --dark-brown: #8C5C03; 
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            overflow-x: hidden; 
        }
        
        /* Background Kiri */
        .bg-left-panel { background-color: #F4AE1A; }
        .text-gold { color: var(--gold-primary) !important; }
        
        /* Tombol Emas */
        .btn-gold { 
            background: linear-gradient(135deg, var(--gold-secondary), var(--gold-primary)); 
            color: white; 
            font-weight: 700; 
            border: none; 
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-gold:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(240, 165, 0, 0.4); 
            color: white; 
        }

        /* Card Form */
        .login-card {
            width: 100%; 
            max-width: 420px;
            border: 1px solid var(--gold-secondary);
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            background-color: #FFFFFF;
        }
        
        /* Ornamen Gambar Asli di pojok kanan atas */
        .corner-blob {
            position: absolute; 
            top: 0; 
            right: 0;
            width: 110px; 
            z-index: 1;
            pointer-events: none; 
        }

        /* Input Kustom */
        .input-group {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .input-group-text { 
            background-color: transparent; 
            border: none; 
            color: var(--gold-primary); 
            padding-left: 1rem; 
        }
        .form-control.custom-input { 
            border: none; 
            padding-left: 5px; 
            box-shadow: none; 
            font-size: 0.9rem; 
        }
        .form-control.custom-input::placeholder { color: #ADB5BD; }
        
        /* Efek fokus pada input */
        .input-group:focus-within { border-color: var(--gold-primary) !important; box-shadow: 0 0 0 0.2rem rgba(240, 165, 0, 0.15); }

        /* Toggle Button (Masuk/Daftar) */
        .toggle-bg { 
            background-color: #F3F4F6; 
            border-radius: 8px; 
            padding: 4px; 
            display: flex; 
            border: 1px solid #E5E7EB;
        }
        .toggle-btn { 
            flex: 1; text-align: center; padding: 8px 0; border-radius: 6px; 
            font-weight: 700; font-size: 0.9rem; text-decoration: none; color: #6B7280; transition: 0.3s; 
        }
        .toggle-btn.active { background-color: white; color: var(--gold-primary); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .toggle-btn:hover:not(.active) { color: var(--gold-primary); }
    </style>
</head>
<body>

<div class="container-fluid px-0">
    <div class="row g-0 min-vh-100">
        
        <div class="col-lg-6 d-none d-lg-flex bg-left-panel flex-column justify-content-center align-items-center p-5 text-center">
            <img src="{{ asset('images/semarputih.png') }}" alt="SEMAR Logo" style="max-height: 350px; margin-bottom: -55px;">
            
            <h1 class="fw-bolder display-6 mb-2" style="color: var(--dark-brown); position: relative; z-index: 2;">Welcome to Semar</h1>
            
            <p class="fs-6 px-xl-5 fw-medium text-white" style="line-height: 1.6; max-width: 550px; position: relative; z-index: 2;">
                Pusat informasi dan pendaftaran event seminar JKB. Cari, daftar, dan dapatkan e-sertifikat dari berbagai acara akademik dengan mudah.
            </p>
        </div>

        <div class="col-lg-6 d-flex justify-content-center align-items-center bg-white p-4">
            <div class="login-card p-4 p-md-5">
                
                <img src="{{ asset('images/elemen1.png') }}" alt="Ornament" class="corner-blob">

                <div class="text-center mb-4 position-relative" style="z-index: 2;">
                    <h2 class="fw-bolder text-gold mb-1">Daftar</h2>
                    <p class="text-dark small fw-semibold">Silahkan Buat Akun SEMAR Anda</p>
                </div>

                <div class="toggle-bg mb-4 position-relative" style="z-index: 2;">
                    <a href="{{ route('login') }}" class="toggle-btn">Masuk</a>
                    <a href="#" class="toggle-btn active">Daftar</a>
                </div>

                <form method="POST" action="{{ route('register') }}" class="position-relative" style="z-index: 2;">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.85rem;">Nama Lengkap</label>
                        <div class="input-group bg-white overflow-hidden py-1">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control custom-input" name="name" value="{{ old('name') }}" required placeholder="Masukkan Nama Lengkap">
                        </div>
                        @error('name')<div class="text-danger mt-1 small fw-medium"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.85rem;">Email Kampus</label>
                        <div class="input-group bg-white overflow-hidden py-1">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control custom-input" name="email" value="{{ old('email') }}" required placeholder="NPM@pnc.ac.id">
                        </div>
                        @error('email')<div class="text-danger mt-1 small fw-medium"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.85rem;">Password</label>
                        <div class="input-group bg-white overflow-hidden py-1">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control custom-input" name="password" required placeholder="Buat Password">
                            <button type="button" class="input-group-text pe-3 toggle-password-btn" style="cursor: pointer; color: #ADB5BD;"><i class="bi bi-eye"></i></button>
                        </div>
                        @error('password')<div class="text-danger mt-1 small fw-medium"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark mb-1" style="font-size: 0.85rem;">Konfirmasi Password</label>
                        <div class="input-group bg-white overflow-hidden py-1">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control custom-input" name="password_confirmation" required placeholder="Ulangi Password">
                            <button type="button" class="input-group-text pe-3 toggle-password-btn" style="cursor: pointer; color: #ADB5BD;"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-2 fs-6 mb-2">Daftar</button>
                    <p class="text-center text-muted mt-2" style="font-size: 0.8rem;">Hanya Civitas JKB yang bisa mendaftar</p>
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
            
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
            
            if(type === 'text') {
                icon.style.color = 'var(--gold-primary)';
            } else {
                icon.style.color = '#ADB5BD';
            }
        });
    });
</script>

</body>
</html>