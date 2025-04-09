<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Platform Distributor & Toko</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <!-- Custom styles -->
    <style>
        :root {
            --primary: #dc3545;
            --primary-dark: #c82333;
            --primary-light: #f27580;
            --secondary: #6c757d;
            --success: #198754;
            --dark: #212529;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
        }

        .btn-outline-light {
            border-radius: 30px;
            padding: 0.8rem 1.5rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            transform: translateY(-3px);
        }

        .navbar {
            padding: 20px 0;
            transition: all 0.3s ease;
        }

        .navbar-scrolled {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            background-color: white !important;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 180px 0 100px;
            position: relative;
        }

        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave svg {
            display: block;
            width: calc(100% + 1.3px);
            height: 99px;
        }

        .wave .shape-fill {
            fill: #FFFFFF;
        }

        .feature-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .counter-box {
            text-align: center;
            padding: 30px 20px;
            border-radius: 15px;
            background-color: var(--primary);
            color: white;
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
            margin-bottom: 30px;
        }

        .counter-box h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .counter-box p {
            font-size: 1.1rem;
            margin-bottom: 0;
            opacity: 0.8;
        }

        .testimonial-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 30px;
            background-color: white;
            position: relative;
        }

        .testimonial-card .quote {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 5rem;
            opacity: 0.1;
            color: var(--primary);
        }

        .testimonial-card img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .partner-logo {
            height: 80px;
            object-fit: contain;
            filter: grayscale(100%);
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .partner-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }

        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 80px 0;
            position: relative;
        }

        .cta-wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
        }

        .cta-wave svg {
            display: block;
            width: calc(100% + 1.3px);
            height: 99px;
        }

        .cta-wave .shape-fill {
            fill: #FFFFFF;
        }

        .footer {
            background-color: #212529;
            color: #adb5bd;
            padding: 60px 0 20px;
        }

        .footer-logo {
            margin-bottom: 20px;
        }

        .footer h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer .nav-link {
            color: #adb5bd;
            padding: 0.2rem 0;
            transition: all 0.3s ease;
        }

        .footer .nav-link:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer .social-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .footer .social-icon:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 30px;
        }

        .step-card {
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 1;
            background-color: white;
            height: 100%;
        }

        .step-card .step-number {
            position: absolute;
            top: -15px;
            left: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .benefits-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .benefits-icon i {
            font-size: 1.8rem;
        }

        .faq-section .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 15px;
            border-radius: 10px;
            overflow: hidden;
        }

        .faq-section .card-header {
            background-color: white;
            border: none;
            padding: 15px 20px;
        }

        .faq-section .btn-link {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            width: 100%;
            text-align: left;
            padding: 0;
            position: relative;
            padding-right: 30px;
        }

        .faq-section .btn-link:after {
            position: absolute;
            content: "\f107";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .faq-section .btn-link[aria-expanded="true"]:after {
            transform: translateY(-50%) rotate(180deg);
        }

        .faq-section .card-body {
            padding: 0 20px 20px;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .border-primary {
            border-color: var(--primary) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .swiper {
            width: 100%;
            padding-bottom: 50px;
        }

        .swiper-slide {
            height: auto;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: var(--primary);
        }

        .swiper-pagination-bullet-active {
            background-color: var(--primary);
        }

        .testimonial-card {
            height: 100%;
            margin: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="fas fa-store me-2 text-primary"></i>{{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#manfaat">Manfaat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cara-kerja">Cara Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonial">Testimonial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">FAQ</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            @if (Auth::user()->role === 'Admin')
                                <li class="nav-item ms-lg-3">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard</a>
                                </li>
                            @else
                                <li class="nav-item ms-lg-3">
                                    <a href="{{ route('toko.dashboard') }}" class="btn btn-primary">Dashboard</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item ms-lg-3">
                                <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item ms-lg-2">
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Daftar</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="display-4 fw-bold mb-4">Tingkatkan Penjualan, Kumpulkan Poin, Raih Keuntungan</h1>
                    <p class="lead mb-4">Bergabunglah dengan platform distributor kami dan dapatkan berbagai keuntungan
                        ekslusif. Jual produk kami dan klaim poin reward untuk setiap transaksi!</p>
                    <div class="d-grid gap-2 d-md-flex">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">Daftar Sekarang</a>
                        @endif
                        <a href="#cara-kerja" class="btn btn-outline-light btn-lg">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left" data-aos-duration="1000"
                    data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1556742031-c6961e8560b0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                        alt="Hero Image" class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
        <div class="wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <section class="py-5" id="fitur">
        <div class="container py-5">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8" data-aos="fade-up">
                    <h6 class="text-primary fw-bold mb-3">FITUR UNGGULAN</h6>
                    <h2 class="display-5 fw-bold mb-4">Solusi Lengkap untuk Toko Anda</h2>
                    <p class="lead">Platform kami dirancang untuk memudahkan pengelolaan toko dan meningkatkan
                        penjualan Anda dengan berbagai fitur canggih.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <h4 class="mb-3">Manajemen Toko</h4>
                        <p class="text-muted">Kelola toko Anda dengan mudah menggunakan dashboard yang intuitif. Lacak
                            penjualan, stok, dan kinerja secara real-time.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h4 class="mb-3">Katalog Produk</h4>
                        <p class="text-muted">Akses katalog produk lengkap dengan informasi detail, stok, harga, dan
                            poin reward untuk setiap produk.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4 class="mb-3">Sistem Poin Reward</h4>
                        <p class="text-muted">Dapatkan poin untuk setiap penjualan dan tukarkan dengan berbagai hadiah
                            menarik atau potongan harga untuk pembelian berikutnya.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="mb-3">Laporan Penjualan</h4>
                        <p class="text-muted">Dapatkan insight bisnis dengan laporan penjualan detail, tren produk, dan
                            analisis penjualan untuk keputusan bisnis yang lebih baik.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="mb-3">Dukungan Pemasaran</h4>
                        <p class="text-muted">Dapatkan materi pemasaran dan promosi untuk membantu meningkatkan
                            penjualan dan menarik lebih banyak pelanggan.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card p-4">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4 class="mb-3">Dukungan 24/7</h4>
                        <p class="text-muted">Tim dukungan kami siap membantu Anda kapan saja. Dapatkan solusi cepat
                            untuk setiap masalah yang Anda hadapi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" id="statistik">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="counter-box">
                        <h2 class="counter">1500+</h2>
                        <p>Toko Bergabung</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="counter-box">
                        <h2 class="counter">50M+</h2>
                        <p>Poin Dibagikan</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="counter-box">
                        <h2 class="counter">95%</h2>
                        <p>Tingkat Kepuasan</p>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="counter-box">
                        <h2 class="counter">24/7</h2>
                        <p>Dukungan Pelanggan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" id="manfaat">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h6 class="text-primary fw-bold mb-3">MANFAAT BERGABUNG</h6>
                    <h2 class="display-5 fw-bold mb-4">Keuntungan Menjadi Mitra Kami</h2>
                    <p class="lead">Bergabunglah dengan kami dan rasakan berbagai manfaat yang akan membantu
                        mengembangkan bisnis Anda.</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1556741533-6e6a62bd8b49?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                        alt="Benefits" class="img-fluid rounded-3 shadow-lg" data-aos="fade-right">
                </div>
                <div class="col-lg-6">
                    <div class="d-flex mb-4" data-aos="fade-left" data-aos-delay="100">
                        <div class="benefits-icon">
                            <i class="fas fa-percent"></i>
                        </div>
                        <div>
                            <h4 class="mb-2">Margin Keuntungan Tinggi</h4>
                            <p class="text-muted mb-0">Dapatkan margin keuntungan yang kompetitif untuk setiap produk
                                yang Anda jual.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4" data-aos="fade-left" data-aos-delay="200">
                        <div class="benefits-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div>
                            <h4 class="mb-2">Program Poin Reward</h4>
                            <p class="text-muted mb-0">Kumpulkan poin untuk setiap transaksi dan tukarkan dengan hadiah
                                atau potongan harga.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4" data-aos="fade-left" data-aos-delay="300">
                        <div class="benefits-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <h4 class="mb-2">Pengiriman Cepat</h4>
                            <p class="text-muted mb-0">Nikmati layanan pengiriman cepat langsung ke toko Anda untuk
                                memastikan stok selalu tersedia.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4" data-aos="fade-left" data-aos-delay="400">
                        <div class="benefits-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h4 class="mb-2">Pelatihan & Pendampingan</h4>
                            <p class="text-muted mb-0">Dapatkan pelatihan dan pendampingan untuk meningkatkan kemampuan
                                bisnis Anda.</p>
                        </div>
                    </div>
                    <div class="d-flex" data-aos="fade-left" data-aos-delay="500">
                        <div class="benefits-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <h4 class="mb-2">Dukungan Pemasaran</h4>
                            <p class="text-muted mb-0">Dapatkan materi promosi dan strategi pemasaran untuk
                                meningkatkan penjualan produk.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" id="cara-kerja">
        <div class="container py-5">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8" data-aos="fade-up">
                    <h6 class="text-primary fw-bold mb-3">CARA KERJA</h6>
                    <h2 class="display-5 fw-bold mb-4">Mulai Dalam 4 Langkah Mudah</h2>
                    <p class="lead">Bergabung dan mendapatkan keuntungan dari program kami sangat mudah. Ikuti
                        langkah-langkah di bawah ini untuk memulai.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4 class="mt-4 mb-3">Daftar</h4>
                        <p class="text-muted">Buat akun di platform kami dengan mengisi informasi toko Anda.</p>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary mt-3">Daftar Sekarang</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4 class="mt-4 mb-3">Verifikasi</h4>
                        <p class="text-muted">Lengkapi verifikasi toko dan tunggu persetujuan dari tim kami.</p>
                        <i class="fas fa-clipboard-check text-primary fs-1 mt-3"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4 class="mt-4 mb-3">Jual Produk</h4>
                        <p class="text-muted">Mulai jual produk dan kumpulkan poin reward dari setiap transaksi.</p>
                        <i class="fas fa-shopping-cart text-primary fs-1 mt-3"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <h4 class="mt-4 mb-3">Klaim Reward</h4>
                        <p class="text-muted">Tukarkan poin yang telah Anda kumpulkan dengan berbagai hadiah menarik.
                        </p>
                        <i class="fas fa-gift text-primary fs-1 mt-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" id="testimonial">
        <div class="container py-5">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8" data-aos="fade-up">
                    <h6 class="text-primary fw-bold mb-3">TESTIMONIAL</h6>
                    <h2 class="display-5 fw-bold mb-4">Apa Kata Mitra Kami</h2>
                    <p class="lead">Dengarkan langsung dari para pemilik toko yang telah bergabung dan merasakan
                        manfaatnya.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="swiper testimonialSwiper">
                        <div class="swiper-wrapper">
                            <!-- Testimonial 1 -->
                            <div class="swiper-slide">
                                <div class="testimonial-card">
                                    <i class="fas fa-quote-right quote"></i>
                                    <div class="d-flex align-items-center mb-4">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Testimonial">
                                        <div class="ms-3">
                                            <h5 class="mb-0">Budi Santoso</h5>
                                            <p class="text-muted mb-0">Pemilik Toko Sejahtera</p>
                                        </div>
                                    </div>
                                    <p class="mb-0">Bergabung dengan platform ini adalah keputusan bisnis terbaik
                                        yang pernah
                                        saya buat. Penjualan meningkat 30% dan sistem poin reward sangat menguntungkan!
                                    </p>
                                    <div class="mt-3">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- Testimonial 2 -->
                            <div class="swiper-slide">
                                <div class="testimonial-card">
                                    <i class="fas fa-quote-right quote"></i>
                                    <div class="d-flex align-items-center mb-4">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Testimonial">
                                        <div class="ms-3">
                                            <h5 class="mb-0">Siti Rahayu</h5>
                                            <p class="text-muted mb-0">Pemilik Toko Berkah</p>
                                        </div>
                                    </div>
                                    <p class="mb-0">Program poin reward sangat menarik dan menguntungkan! Saya sudah
                                        menukarkan
                                        poin dengan berbagai hadiah dan potongan harga untuk pesanan berikutnya.</p>
                                    <div class="mt-3">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- Testimonial 3 -->
                            <div class="swiper-slide">
                                <div class="testimonial-card">
                                    <i class="fas fa-quote-right quote"></i>
                                    <div class="d-flex align-items-center mb-4">
                                        <img src="https://randomuser.me/api/portraits/men/66.jpg" alt="Testimonial">
                                        <div class="ms-3">
                                            <h5 class="mb-0">Agus Pranoto</h5>
                                            <p class="text-muted mb-0">Pemilik Toko Makmur</p>
                                        </div>
                                    </div>
                                    <p class="mb-0">Dukungan tim sangat luar biasa! Mereka membantu saya dari awal
                                        pendaftaran
                                        hingga strategi pemasaran. Toko saya kini menjadi lebih ramai dan profit
                                        meningkat.</p>
                                    <div class="mt-3">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- Tambahkan testimonial lain jika diperlukan -->
                        </div>
                        <!-- Navigasi -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" id="partner">
        <div class="container py-5">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8" data-aos="fade-up">
                    <h6 class="text-primary fw-bold mb-3">PARTNER KAMI</h6>
                    <h2 class="display-5 fw-bold mb-4">Dipercaya oleh Brand Terkemuka</h2>
                    <p class="lead">Kami bermitra dengan brand terkemuka untuk menyediakan produk berkualitas untuk
                        toko Anda.</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-2 col-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Samsung_Logo.svg/1280px-Samsung_Logo.svg.png"
                        alt="Partner" class="img-fluid partner-logo mx-auto d-block">
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="200">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/HP_logo_2012.svg/1200px-HP_logo_2012.svg.png"
                        alt="Partner" class="img-fluid partner-logo mx-auto d-block">
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="300">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/1200px-Google_2015_logo.svg.png"
                        alt="Partner" class="img-fluid partner-logo mx-auto d-block">
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="400">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/1024px-Apple_logo_black.svg.png"
                        alt="Partner" class="img-fluid partner-logo mx-auto d-block" style="height: 60px;">
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="500">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Microsoft_logo.svg/1024px-Microsoft_logo.svg.png"
                        alt="Partner" class="img-fluid partner-logo mx-auto d-block">
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="600">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Amazon_logo.svg/1024px-Amazon_logo.svg.png"
                        alt="Partner" class="img-fluid partner-logo mx-auto d-block">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" id="faq">
        <div class="container py-5">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8" data-aos="fade-up">
                    <h6 class="text-primary fw-bold mb-3">FAQ</h6>
                    <h2 class="display-5 fw-bold mb-4">Pertanyaan Umum</h2>
                    <p class="lead">Temukan jawaban untuk pertanyaan yang sering diajukan tentang program kami.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 faq-section">
                    <div class="accordion" id="accordionFAQ">
                        <div class="card" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Bagaimana cara bergabung dengan program ini?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionFAQ">
                                <div class="card-body">
                                    Untuk bergabung dengan program kami, Anda perlu mendaftar di website ini dengan
                                    mengisi informasi toko Anda. Setelah verifikasi, Anda akan memiliki akses ke seluruh
                                    fitur platform kami.
                                </div>
                            </div>
                        </div>
                        <div class="card" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Bagaimana sistem poin reward bekerja?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionFAQ">
                                <div class="card-body">
                                    Setiap produk yang Anda jual memiliki nilai poin tertentu. Setiap kali Anda
                                    melakukan penjualan, poin akan otomatis ditambahkan ke akun Anda. Poin tersebut
                                    dapat ditukarkan dengan berbagai hadiah atau potongan harga untuk pembelian
                                    berikutnya.
                                </div>
                            </div>
                        </div>
                        <div class="card" data-aos="fade-up" data-aos-delay="300">
                            <div class="card-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        Apakah ada biaya pendaftaran?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionFAQ">
                                <div class="card-body">
                                    Tidak, pendaftaran untuk menjadi mitra kami sepenuhnya gratis. Anda hanya perlu
                                    memenuhi persyaratan verifikasi toko untuk bergabung.
                                </div>
                            </div>
                        </div>
                        <div class="card" data-aos="fade-up" data-aos-delay="400">
                            <div class="card-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Berapa lama proses verifikasi toko?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionFAQ">
                                <div class="card-body">
                                    Proses verifikasi toko biasanya membutuhkan waktu 1-3 hari kerja. Tim kami akan
                                    melakukan verifikasi untuk memastikan informasi yang Anda berikan valid.
                                </div>
                            </div>
                        </div>
                        <div class="card" data-aos="fade-up" data-aos-delay="500">
                            <div class="card-header" id="headingFive">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        Bagaimana cara menukarkan poin?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                                data-bs-parent="#accordionFAQ">
                                <div class="card-body">
                                    Untuk menukarkan poin, Anda dapat mengunjungi halaman "Tukar Poin" di dashboard
                                    Anda. Pilih hadiah yang Anda inginkan dan klik tombol "Tukar". Poin akan otomatis
                                    dipotong dari saldo Anda.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="shape-fill"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="shape-fill"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="shape-fill"></path>
            </svg>
        </div>
        <div class="container py-5">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4">Siap Bergabung dan Dapatkan Poin Reward?</h2>
                    <p class="lead mb-5">Daftarkan toko Anda sekarang dan mulai rasakan manfaatnya!</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">Daftar Sekarang</a>
                        @endif
                        <a href="#cara-kerja" class="btn btn-outline-light btn-lg">Pelajari Cara Kerjanya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <a class="navbar-brand fw-bold text-white mb-3 d-block footer-logo" href="{{ url('/') }}">
                        <i class="fas fa-store me-2 text-primary"></i>{{ config('app.name', 'Laravel') }}
                    </a>
                    <p class="mb-4">Platform distributor terkemuka yang menghubungkan perusahaan dengan toko-toko di
                        seluruh Indonesia. Nikmati rewards dan keuntungan setiap kali Anda menjual produk kami.</p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/p/Wijaya-Inovasi-Gemilang-100087679726435/"
                            class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/@wijayainovasigemilang" class="social-icon"
                            target="_blank"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.instagram.com/wijayainovasigemilang.official/" class="social-icon"
                            target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/ptwijayainovasigemilang" class="social-icon"
                            target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h5>Kontak Kami</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-3">
                            <div class="d-flex">
                                <i class="fas fa-map-marker-alt text-primary me-3 mt-1"></i>
                                <p class="mb-0">Jl. Prawiro Sudiyono No.105, Jongke Tengah, Sendangadi, Kec. Mlati,
                                    Kabupaten Sleman, Daerah Istimewa Yogyakarta. 55285</p>
                            </div>
                        </li>
                        <li class="nav-item mb-3">
                            <div class="d-flex">
                                <i class="fas fa-phone-alt text-primary me-3 mt-1"></i>
                                <p class="mb-0">+62 816-3344-16</p>
                            </div>
                        </li>
                        <li class="nav-item mb-3">
                            <div class="d-flex">
                                <i class="fas fa-envelope text-primary me-3 mt-1"></i>
                                <p class="mb-0">info@wijayainovasi.co.id</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights
                    reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script>
        // Initialize AOS
        AOS.init();

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
                navbar.classList.remove('bg-transparent');
                navbar.classList.add('bg-white');
            } else {
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.add('bg-transparent');
                navbar.classList.remove('bg-white');
            }
        });
        // Initialize Swiper
        const testimonialSwiper = new Swiper('.testimonialSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                }
            }
        });
    </script>
</body>

</html>
