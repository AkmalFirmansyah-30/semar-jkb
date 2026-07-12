<nav class="fixed-top shadow-sm w-100" style="background-color: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); z-index: 1030;">
    <div class="container d-flex justify-content-between align-items-center py-3">
        
        <a class="d-flex align-items-center text-decoration-none" href="{{ url('/') }}">
            <img src="{{ asset('images/semar.png') }}" alt="Logo SEMAR JKB" style="height: 40px; object-fit: contain;">
        </a>

        <div class="d-none d-lg-flex gap-4 fw-semibold align-items-center">
            <a href="{{ url('/') }}#beranda" class="text-dark text-decoration-none nav-hover">Beranda</a>
            <a href="{{ url('/') }}#fitur" class="text-dark text-decoration-none nav-hover">Fitur Unggulan</a>
            <a href="{{ url('/') }}#alur" class="text-dark text-decoration-none nav-hover">Alur Proses</a>
            <a href="{{ url('/') }}#faq" class="text-dark text-decoration-none nav-hover">FaQ</a>
        </div>

        <div class="d-none d-lg-block">
            @if (Route::has('login'))
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-gold-nav px-4 rounded-pill shadow-sm d-inline-flex align-items-center gap-2">
                            Logout <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold-nav px-4 rounded-pill shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-in-right fs-5"></i> Login
                    </a>
                @endauth
            @endif
        </div>

        <button class="btn d-lg-none border-0 fs-2 p-0 text-dark focus-ring focus-ring-warning" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="collapse d-lg-none bg-white border-top shadow-sm" id="mobileMenu">
        <div class="container py-4 d-flex flex-column gap-3 fw-semibold text-center">
            <a href="{{ url('/') }}#beranda" class="text-dark text-decoration-none nav-hover">Beranda</a>
            <a href="{{ url('/') }}#fitur" class="text-dark text-decoration-none nav-hover">Fitur Unggulan</a>
            <a href="{{ url('/') }}#alur" class="text-dark text-decoration-none nav-hover">Alur Proses</a>
            <a href="{{ url('/') }}#faq" class="text-dark text-decoration-none nav-hover">FaQ</a>
            <hr class="text-muted my-2 opacity-25">
            @if (Route::has('login'))
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="d-grid px-4">
                        @csrf
                        <button type="submit" class="btn btn-gold-nav rounded-pill py-2 shadow-sm d-flex justify-content-center align-items-center gap-2">
                            Logout <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-gold-nav rounded-pill mx-4 py-2 shadow-sm d-flex justify-content-center align-items-center gap-2">
                        <i class="bi bi-box-arrow-in-right fs-5"></i> Login
                    </a>
                @endauth
            @endif
        </div>
    </div>
</nav>

<style>
    .nav-hover { 
        position: relative;
        transition: color 0.3s ease-in-out; 
    }
    .nav-hover:hover { 
        color: #F5A623 !important; 
    }

    .btn-gold-nav {
        background: linear-gradient(135deg, #FFC837, #F5A623);
        color: #121212;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-gold-nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 166, 35, 0.4) !important;
        color: #000;
    }
</style>