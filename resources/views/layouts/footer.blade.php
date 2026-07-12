<style>
    /* Custom Styling Footer */
    .footer-cream {
        background: linear-gradient(180deg, #FDFBF4 0%, #FDF1D6 100%); 
        color: #1A202C;
    }
    .text-gold-footer {
        color: #C68B25; 
        font-weight: 700;
    }
    .footer-link {
        color: #4A5568;
        text-decoration: none;
        margin-bottom: 0.8rem;
        display: inline-block;
        font-weight: 500;
        transition: color 0.3s ease, transform 0.3s ease;
    }
    .footer-link:hover {
        color: #F5A623;
        transform: translateX(5px); /* Memberikan efek geser sedikit saat di-hover */
    }
</style>

<footer class="footer-cream pt-5 pb-3 border-top">
    <div class="container">
        <div class="row gy-4 mb-4">
            
            <div class="col-lg-5 pe-lg-5">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/logo_semar.png') }}" alt="Logo SEMAR" height="40" class="me-2">
                    <h4 class="text-gold-footer mb-0" style="letter-spacing: 0.5px;">SEMAR JKB</h4>
                </div>
                <p style="line-height: 1.7; font-weight: 500; color: #4A5568; font-size: 0.95rem;">
                    Portal Event Seminar terintegrasi. Kami bertransformasi untuk menciptakan ekosistem akademik yang digital, efisien, dan transparan untuk memudahkan partisipasi mahasiswa dalam berbagai kegiatan keilmuan.
                </p>
            </div>

            <div class="col-lg-3">
                <h5 class="text-gold-footer mb-4">Tautan Cepat</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="#beranda" class="footer-link"><i class="bi bi-chevron-right me-1" style="font-size: 0.8rem;"></i> Beranda</a></li>
                    <li><a href="#fitur" class="footer-link"><i class="bi bi-chevron-right me-1" style="font-size: 0.8rem;"></i> Fitur Unggulan</a></li>
                    <li><a href="#alur" class="footer-link"><i class="bi bi-chevron-right me-1" style="font-size: 0.8rem;"></i> Alur Proses</a></li>
                    <li><a href="#faq" class="footer-link"><i class="bi bi-chevron-right me-1" style="font-size: 0.8rem;"></i> FaQ</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h5 class="text-gold-footer mb-4">Kontak</h5>
                <div class="d-flex mb-3" style="color: #4A5568;">
                    <i class="bi bi-geo-alt-fill me-3 mt-1 fs-5 text-gold-footer"></i>
                    <span style="font-weight: 500; line-height: 1.6; font-size: 0.95rem;">Jl. Dr. Soetomo No. 1 Sidakaya, Cilacap</span>
                </div>
                <a href="https://jkb.pnc.ac.id/" target="_blank" class="text-gold-footer text-decoration-none d-inline-flex align-items-center mt-2 hover-opacity" style="transition: opacity 0.3s;">
                    Kunjungi Website <i class="bi bi-link-45deg ms-1 fs-4"></i>
                </a>
            </div>

        </div>

        <hr style="border-color: #1A202C; opacity: 0.15; margin-top: 2rem; margin-bottom: 1.5rem;">

        <div class="row align-items-center">
            <div class="col-md-8 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-0" style="font-weight: 500; font-size: 0.9rem; color: #4A5568;">
                    &copy; 2026 SEMAR - Jurusan Komputer dan Bisnis, Politeknik Negeri Cilacap.
                </p>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <a href="#" class="footer-link mb-0" style="font-size: 0.9rem;">Pusat Bantuan</a>
            </div>
        </div>
    </div>
</footer>