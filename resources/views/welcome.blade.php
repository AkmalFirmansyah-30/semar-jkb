<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEMAR JKB - Politeknik Negeri Cilacap</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* Palet Warna Utama SEMAR JKB */
        :root {
            --gold-primary: #F5A623;
            --gold-gradient: linear-gradient(135deg, #FFC837 0%, #F5A623 100%);
            --charcoal-slate: #1A202C;
            --slate-muted: #4A5568;
            --cream-bg: #FDFBF4;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            overflow-x: hidden; 
            scroll-behavior: smooth; 
            color: var(--charcoal-slate);
        }
        
        /* Utilitas Warna & Background */
        .text-gold { color: var(--gold-primary) !important; }
        .bg-gold { background: var(--gold-gradient) !important; color: white; }
        .bg-cream { background-color: var(--cream-bg); }

        /* Styling Tombol Custom */
        .btn-gold {
            background: var(--gold-gradient); 
            color: #121212;
            font-weight: 700; 
            border: none; 
            transition: all 0.3s ease;
        }
        .btn-gold:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(245, 166, 35, 0.4); 
            color: #000; 
        }
        
        .hover-outline {
            transition: all 0.3s ease;
        }
        .hover-outline:hover {
            background-color: var(--gold-primary) !important;
            color: #FFFFFF !important;
            box-shadow: 0 4px 12px rgba(245, 166, 35, 0.3) !important;
            border-color: var(--gold-primary) !important;
        }

        /* Animasi Hover Card Umum */
        .hover-up { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-up:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }

        /* Animasi Mengambang (Floating) untuk Logo Hero */
        .floating-img {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        /* Timeline Vertikal Custom */
        .timeline-section { background-color: #FBFBFB; position: relative; padding: 5rem 0; }
        .timeline { position: relative; max-width: 900px; margin: 0 auto; }
        
        .timeline::after {
            content: ''; position: absolute; width: 2px; background-color: var(--gold-primary);
            top: 0; bottom: 0; left: 50%; transform: translateX(-50%); z-index: 1;
        }
        
        .container-timeline { padding: 10px 50px; position: relative; width: 50%; z-index: 2; }
        .container-timeline.left { left: 0; }
        .container-timeline.right { left: 50%; }

        .timeline-number {
            position: absolute; top: 15px; width: 50px; height: 50px; border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #FFE180 0%, #D89F3C 80%, #B88022 100%);
            box-shadow: 0 4px 10px rgba(245,166,35,0.4);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; font-weight: 800; color: var(--charcoal-slate); z-index: 3;
        }
        
        .left .timeline-number { right: -25px; }
        .right .timeline-number { left: -25px; }

        .content-timeline {
            padding: 24px 30px; background-color: #FFFFFF; position: relative;
            border-radius: 8px; border: 1.5px solid var(--gold-primary);
            box-shadow: 0 8px 20px rgba(0,0,0,0.03); text-align: left;
        }

        /* =========================================
           FAQ Accordion Styling (Tampilan Rapih & Mulus) 
           ========================================= */
        .faq-section {
            background: var(--gold-gradient);
        }

        .custom-accordion .accordion-item {
            background-color: transparent;
            border: none;
            margin-bottom: 1.5rem;
        }

        /* State Tertutup (Bentuk Kapsul/Pill penuh) */
        .custom-accordion .accordion-button {
            background-color: var(--cream-bg); 
            color: var(--charcoal-slate); 
            font-weight: 600;
            font-size: 1.05rem;
            border-radius: 50px !important; 
            padding: 20px 35px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(245, 166, 35, 0.15);
            transition: all 0.3s ease;
        }
        
        /* State Terbuka (Bawahnya lurus menyatu dengan body) */
        .custom-accordion .accordion-button:not(.collapsed) {
            background-color: #FFFFFF;
            color: var(--gold-primary);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            border-radius: 25px 25px 0 0 !important; 
            border-bottom: 1px dashed rgba(245, 166, 35, 0.3);
        }

        .custom-accordion .accordion-button:focus {
            box-shadow: none;
            outline: none;
        }

        .custom-accordion .accordion-button::after {
            display: none; 
        }

        /* Kotak Jawaban (Hanya sudut bawah yang melengkung) */
        .custom-accordion .accordion-body {
            background-color: #FFFFFF;
            border-radius: 0 0 25px 25px; 
            padding: 25px 35px 30px 35px; 
            color: var(--slate-muted);
            font-size: 1rem;
            line-height: 1.7;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(245, 166, 35, 0.15);
            border-top: none;
        }

        .icon-chevron {
            transition: transform 0.3s ease;
            color: var(--gold-primary);
        }
        .accordion-button:not(.collapsed) .icon-chevron {
            transform: rotate(90deg); 
        }

        .icon-question {
            color: var(--gold-primary);
        }

        /* Responsive Mobile */
        @media screen and (max-width: 768px) {
            .timeline::after { left: 40px; transform: none; }
            .container-timeline { width: 100%; padding-left: 90px; padding-right: 20px; }
            .container-timeline.right { left: 0; }
            .left .timeline-number, .right .timeline-number { left: 15px; }
            .custom-accordion .accordion-button { padding: 15px 20px; font-size: 0.95rem; }
            .custom-accordion .accordion-body { padding: 20px; }
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <section id="beranda" class="pt-5 mt-5 bg-cream">
        <div class="container pt-5 pb-5">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                    <span class="badge bg-gold text-dark mb-3 px-3 py-2 rounded-pill">Jurusan Komputer dan Bisnis</span>
                    <h1 class="display-4 fw-bolder text-dark mb-3">Portal Akademik <br><span class="text-gold">SEMAR JKB</span></h1>
                    <p class="lead text-muted mb-4 fs-5">Sistem Manajemen Seminar dan Sidang — Otomasi Penuh dari pengajuan berkas hingga penilaian akhir dalam satu platform terintegrasi.</p>
                    <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-gold btn-lg px-4 rounded-pill">Buka Portal</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-gold btn-lg px-4 rounded-pill">Masuk Portal</a>
                            @endauth
                        @endif
                        <a href="#alur" class="btn btn-outline-gold btn-lg px-4 rounded-pill bg-white">Lihat Timeline</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/logo_semar.png') }}" alt="SEMAR Illustration" class="img-fluid floating-img" style="max-height: 450px; filter: drop-shadow(0 20px 30px rgba(245,166,35,0.3));">
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-5 bg-gold position-relative overflow-hidden">
        <img src="{{ asset('images/awan.png') }}" alt="Dekorasi Awan Kiri" class="position-absolute" style="top: 10px; left: -10px; width: 250px; z-index: 0;">
        <img src="{{ asset('images/awan.png') }}" alt="Dekorasi Awan Kanan" class="position-absolute" style="top: 10px; right: -10px; width: 250px; transform: scaleX(-1); z-index: 0;">

        <div class="container py-5 position-relative" style="z-index: 1;">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3 text-white">Fitur Unggulan</h2>
                <div style="width: 120px; height: 5px; background-color: #d97706; margin: 0 auto 20px; border-radius: 5px;"></div>
                <p class="text-white">Tiga Pilar Utama SEMAR untuk mengelola proses akademik<br>secara efisien</p>
            </div>
            <div class="row g-4 px-lg-5">
                <div class="col-md-4">
                    <div class="card h-100 border-0 rounded-4 shadow p-4 text-center bg-white hover-up">
                        <div class="mb-3"><i class="bi bi-calendar-check text-gold" style="font-size: 3rem;"></i></div>
                        <h5 class="fw-bold text-dark">Penjadwalan Otomatis</h5>
                        <p class="text-muted small">Sistem penjadwalan cerdas yang meminimalisir bentrok jadwal dosen dan ruangan secara otomatis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 rounded-4 shadow p-4 text-center bg-white hover-up">
                        <div class="mb-3"><i class="bi bi-file-earmark-check text-gold" style="font-size: 3rem;"></i></div>
                        <h5 class="fw-bold text-dark">Verifikasi Digital</h5>
                        <p class="text-muted small">Proses verifikasi berkas secara digital dengan status tracking real-time untuk setiap tahapan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 rounded-4 shadow p-4 text-center bg-white hover-up">
                        <div class="mb-3"><i class="bi bi-award text-gold" style="font-size: 3rem;"></i></div>
                        <h5 class="fw-bold text-dark">Penilaian Terintegrasi</h5>
                        <p class="text-muted small">Portal penilaian digital dengan kalkulasi otomatis dan penguncian nilai permanen.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="alur" class="py-5 timeline-section">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #F5A623;">Alur Proses</h2>
                <p class="text-muted">Lima langkah mudah dari pencarian event sampai mendapatkan sertifikat kehadiran</p>
            </div>

            <div class="timeline">
                <div class="container-timeline left">
                    <div class="timeline-number">1</div>
                    <div class="content-timeline hover-up">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="bi bi-box-arrow-in-right text-gold me-2 fs-5"></i>Login & Akses
                        </h6>
                        <p class="text-muted mb-0 small" style="line-height: 1.6;">Mahasiswa masuk menggunakan akun email kampus (@pnc.ac.id). Sistem terintegrasi Single Sign-On untuk keamanan data.</p>
                    </div>
                </div>
                
                <div class="container-timeline right">
                    <div class="timeline-number">2</div>
                    <div class="content-timeline hover-up">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="bi bi-search text-gold me-2 fs-5"></i>Eksplorasi Event
                        </h6>
                        <p class="text-muted mb-0 small" style="line-height: 1.6;">Cari dan eksplorasi daftar event seminar atau sidang terbuka yang kuotanya masih tersedia untuk pendaftaran.</p>
                    </div>
                </div>
                
                <div class="container-timeline left">
                    <div class="timeline-number">3</div>
                    <div class="content-timeline hover-up">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="bi bi-cursor text-gold me-2 fs-5"></i>Registrasi Kehadiran
                        </h6>
                        <p class="text-muted mb-0 small" style="line-height: 1.6;">Klik daftar pada seminar yang diminati melalui portal SEMAR untuk memesan kursi/kuota peserta secara instan.</p>
                    </div>
                </div>
                
                <div class="container-timeline right">
                    <div class="timeline-number">4</div>
                    <div class="content-timeline hover-up">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="bi bi-qr-code-scan text-gold me-2 fs-5"></i>Presensi Digital
                        </h6>
                        <p class="text-muted mb-0 small" style="line-height: 1.6;">Hadir di lokasi pada hari pelaksanaan dan lakukan scan QR Code untuk mencatat kehadiran resmi Anda.</p>
                    </div>
                </div>
                
                <div class="container-timeline left">
                    <div class="timeline-number">5</div>
                    <div class="content-timeline hover-up">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="bi bi-award text-gold me-2 fs-5"></i>Klaim Sertifikat
                        </h6>
                        <p class="text-muted mb-0 small" style="line-height: 1.6;">Unduh E-Sertifikat secara langsung melalui dashboard riwayat seminar setelah status kehadiran dikonfirmasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-5 faq-section">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-white mb-3">Pertanyaan Umum</h2>
                <div style="width: 80px; height: 4px; background-color: rgba(255,255,255,0.5); margin: 0 auto; border-radius: 2px;"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="accordion custom-accordion" id="faqAccordion">
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-question-circle-fill icon-question fs-5"></i>
                                            <span>Bagaimana cara mendaftar akun SEMAR?</span>
                                        </div>
                                        <i class="bi bi-chevron-right icon-chevron fs-5"></i>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Anda tidak perlu mendaftar manual. Gunakan Email Kampus Anda (NIM@pnc.ac.id) untuk langsung login ke dalam sistem menggunakan SSO (Single Sign-On).
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-question-circle-fill icon-question fs-5"></i>
                                            <span>Apakah ada batasan kuota untuk mengikuti seminar?</span>
                                        </div>
                                        <i class="bi bi-chevron-right icon-chevron fs-5"></i>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, setiap event seminar memiliki batas kuota audiens yang ditetapkan oleh penyelenggara. Pendaftaran akan otomatis ditutup saat kuota penuh, jadi pastikan Anda mendaftar lebih awal!
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-question-circle-fill icon-question fs-5"></i>
                                            <span>Bagaimana cara mendapatkan E-Sertifikat?</span>
                                        </div>
                                        <i class="bi bi-chevron-right icon-chevron fs-5"></i>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    E-Sertifikat dapat diunduh langsung melalui menu 'Riwayat Seminar' di dashboard akun Anda. Syarat utamanya adalah Anda harus hadir di lokasi dan melakukan presensi digital (scan QR Code) pada hari H.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-question-circle-fill icon-question fs-5"></i>
                                            <span>Siapa saja yang bisa mendaftar event di SEMAR?</span>
                                        </div>
                                        <i class="bi bi-chevron-right icon-chevron fs-5"></i>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Seluruh mahasiswa aktif Politeknik Negeri Cilacap, khususnya mahasiswa di lingkungan Jurusan Komputer dan Bisnis (JKB), dapat mencari dan mendaftar sebagai peserta (audiens) pada berbagai acara seminar yang tersedia.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>