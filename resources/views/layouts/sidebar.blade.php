<style>
    /* Desain Latar Belakang Sidebar */
    .sidebar-gold {
        background: linear-gradient(180deg, #F8C330 0%, #E68A00 100%);
        border-right: none !important;
    }

    /* Desain Link/Menu Sidebar */
    .sidebar-menu-link {
        color: rgba(255, 255, 255, 0.85); /* Putih sedikit transparan */
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        font-size: 1.05rem;
        padding: 12px 20px;
    }

    .sidebar-menu-link i {
        font-size: 1.25rem;
        width: 35px; /* Mengunci lebar ikon agar teks sebelahnya sejajar rata */
    }

    /* Efek Hover (Saat disorot) */
    .sidebar-menu-link:hover {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.15); /* Highlight putih transparan */
        border-radius: 8px;
        transform: translateX(5px);
    }

    /* Efek Active (Menu yang sedang dibuka) */
    .active-menu {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.25);
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    /* Judul Kategori Sidebar (Manajemen, Akademik, dll) */
    .sidebar-heading {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
</style>

<div class="sidebar sidebar-gold shadow-sm h-100 position-fixed" style="width: 260px; z-index: 1040; transition: all 0.3s;">
    
    <div class="d-flex flex-column align-items-center justify-content-center py-5">
        <img src="{{ asset('images/semarputih.png') }}" alt="Logo SEMAR" style="height: 250px; margin-bottom: -55px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
        <h3 class="fw-bolder text-white mt-3 mb-0" style="letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">SEMAR JKB</h3>
    </div>

    <div class="px-3 pb-4">
        <ul class="nav flex-column gap-2">
            
            @if(Auth::user()->role === 'mahasiswa')
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('/') ? 'active-menu' : '' }}" href="{{ url('/') }}">
                        <i class="bi bi-house-door-fill"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('mahasiswa/dashboard') ? 'active-menu' : '' }}" href="{{ route('mahasiswa.dashboard') }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('mahasiswa/pengajuan') ? 'active-menu' : '' }}" href="{{ route('mahasiswa.pengajuan') }}">
                        <i class="bi bi-file-earmark-arrow-up-fill"></i> Pengajuan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('mahasiswa/jadwal') ? 'active-menu' : '' }}" href="{{ route('mahasiswa.jadwal') }}">
                        <i class="bi bi-calendar-week"></i> Jadwal & Hasil
                    </a>
                </li>
            @endif

            @if(Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('admin/dashboard') ? 'active-menu' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-grid-fill"></i> Dashboard Admin
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <p class="text-uppercase fw-bold sidebar-heading px-3 mb-1">Manajemen</p>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('admin/verifikasi') ? 'active-menu' : '' }}" href="{{ route('admin.verifikasi') }}">
                        <i class="bi bi-shield-fill-check"></i> Verifikasi Berkas
                        <span class="badge bg-white text-warning rounded-pill ms-auto" style="font-size: 0.7rem;">3</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('admin/jadwal') ? 'active-menu' : '' }}" href="{{ route('admin.jadwal') }}">
                        <i class="bi bi-calendar-range-fill"></i> Kelola Jadwal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('admin/pengguna') ? 'active-menu' : '' }}" href="{{ route('admin.pengguna') }}">
                        <i class="bi bi-people-fill"></i> Data Pengguna
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('admin/rekapitulasi') ? 'active-menu' : '' }}" href="{{ route('admin.rekapitulasi') }}">
                        <i class="bi bi-table"></i> Rekapitulasi Nilai
                    </a>
                </li>
            @endif

            @if(Auth::user()->role === 'dosen')
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('dosen/dashboard') ? 'active-menu' : '' }}" href="{{ route('dosen.dashboard') }}">
                        <i class="bi bi-grid-fill"></i> Dashboard Dosen
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <p class="text-uppercase fw-bold sidebar-heading px-3 mb-1">Akademik</p>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('dosen/jadwal') ? 'active-menu' : '' }}" href="{{ route('dosen.jadwal') }}">
                        <i class="bi bi-calendar-check-fill"></i> Jadwal Menguji
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar-menu-link {{ request()->is('dosen/penilaian/*') ? 'active-menu' : '' }}" href="{{ route('dosen.jadwal') }}">
                        <i class="bi bi-pencil-square"></i> Input Nilai
                        <span class="badge bg-white text-warning rounded-pill ms-auto" style="font-size: 0.7rem;">1</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>