<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEMAR JKB - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f4f6f9; 
            overflow-x: hidden; 
        }
        
        .text-gold { color: #F5A623 !important; }
        .bg-gold { background: linear-gradient(135deg, #FFC837, #F5A623) !important; color: #121212; }

        #main-content { 
            margin-left: 260px; 
            transition: all 0.3s; 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
        }

        /* Styling Profile Dropdown agar sesuai referensi */
        .profile-text-header {
            line-height: 1.2;
        }
        .profile-name {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.02em;
        }
        .profile-role {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        .profile-circle {
            width: 45px;
            height: 45px;
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s ease;
        }
        .profile-circle:hover {
            border-color: #F5A623;
            background-color: #fffaf0;
        }

        @media (max-width: 992px) { 
            #main-content { margin-left: 0; } 
            .sidebar { display: none; } 
        }
    </style>
</head>
<body>

    @include('layouts.sidebar')

    <div id="main-content">
        
        <nav class="navbar navbar-expand bg-white shadow-sm px-4 py-2">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark d-none d-md-block">Portal Akademik {{ ucfirst(Auth::user()->role) }}</span>
                
                <div class="d-flex align-items-center ms-auto">
                    <div class="text-end me-3 d-none d-sm-block profile-text-header">
                        <div class="profile-name">{{ Auth::user()->name }}</div>
                        <div class="profile-role text-uppercase">{{ Auth::user()->role }}</div>
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn profile-circle rounded-circle d-flex align-items-center justify-content-center p-0 shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill text-secondary fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-4 p-2" style="min-width: 200px;">
                            <li class="px-3 py-2 d-md-none">
                                <div class="profile-name">{{ Auth::user()->name }}</div>
                                <div class="profile-role text-uppercase">{{ Auth::user()->role }}</div>
                                <hr>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-3 py-2 fw-semibold" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear me-2 text-gold"></i> Pengaturan Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-3 py-2 fw-semibold text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="p-4 p-md-5 flex-grow-1">
            @include('layouts._flash')
            @yield('content')
        </main>

        <footer class="bg-white text-center py-3 border-top mt-auto text-muted small">
            &copy; 2026 SEMAR JKB - Jurusan Komputer dan Bisnis PNC.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>