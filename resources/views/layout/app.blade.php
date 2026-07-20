<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPSKE - Laboratorium Perancangan Sistem Kerja dan Ergonomi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- Livewire Styles --}}
    @livewireStyles

    <style>
        :root {
            --primary-color: rgba(82, 103, 132, 1);
            --secondary-color: rgb(176, 99, 13);
            --accent-color: rgba(195, 208, 227, 1);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            color: var(--primary-color) !important;
            font-weight: 500;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--accent-color), white);
            padding: 100px 0;
        }
        
        .section-title {
            color: var(--primary-color);
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: var(--secondary-color);
        }
        
        .section-title.text-center:after {
            left: 50%;
            right: auto;
            transform: translateX(-50%);
        }
        
        footer {
            background: linear-gradient(135deg, var(--primary-color), #2c3e50);
            color: white;
            padding: 60px 0 30px;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
        }
        
        footer h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
            text-transform: uppercase;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }
        
        footer h5::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--secondary-color);
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 15px;
        }
        
        .footer-links a::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--secondary-color);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 20px;
            text-decoration: none;
        }
        
        .footer-links a:hover::before {
            opacity: 1;
            left: -5px;
        }
        
        footer p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.7;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        footer hr {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 30px 0 20px;
        }
        
        footer .text-center {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('images/logo_lpske.png') }}" alt="LPSKE Logo" height="40" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#home">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="asistenDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Asisten Laboratorium
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="asistenDropdown">
                            <li><a class="dropdown-item" href="{{ route('asisten-laboratorium') }}">Semua Asisten</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('asisten-laboratorium', ['angkatan' => 2020]) }}">Angkatan 2020</a></li>
                            <li><a class="dropdown-item" href="{{ route('asisten-laboratorium', ['angkatan' => 2019]) }}">Angkatan 2019</a></li>
                            <li><a class="dropdown-item" href="{{ route('asisten-laboratorium', ['angkatan' => 2018]) }}">Angkatan 2018</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('kepala-laboratorium') }}">Kepala Laboratorium</a></li>
                            <li><a class="dropdown-item" href="{{ route('dosen-laboratorium') }}">Dosen Laboratorium</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('prestasi-kegiatan.index') }}">Prestasi & Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.alumni.index') }}">Alumni</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>LPSKE</h5>
                    <p>Laboratorium Perancangan Sistem Kerja dan Ergonomi (LPSKE) merupakan salah satu dari enam laboratorium yang dimiliki oleh Teknik Industri Universitas Sebelas Maret.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Link Cepat</h5>
                    <div class="footer-links">
                        <a href="#">Beranda</a>
                        <a href="#about">Tentang Kami</a>
                        <a href="#facilities">Fasilitas & SOP</a>
                        <a href="#prestasi-kegiatan">Prestasi & Kegiatan</a>
                        <a href="#alumni">Alumni</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Kontak Kami</h5>
                    <p class="contact-info">
                        <a href="https://www.google.com/search?sca_esv=7a35ca30b0eec527&cs=1&output=search&tbm=lcl&kgmid=%2Fg%2F11ghq3_0tj&q=Gedung%203%20Fakultas%20Teknik%20UNS&shndl=30&shem=lcuae%2Csdl1p%2Cuaasie&source=sh%2Fx%2Floc%2Funi%2Fm1%2F1&kgs=6007564504d98bb0#rlfi=hd:;si:;mv:[[-7.558102942500253,110.84703905771357],[-7.564037597432735,110.83718995692266]]" target="_blank" class="text-decoration-none text-white">
                            <i class="fas fa-map-marker-alt me-2"></i> Jl. Ir. Sutami 36A, Surakarta
                        </a><br>
                        <a href="tel:0271-646994" target="_blank" class="text-decoration-none text-white">
                            <i class="fab fa-whatsapp me-2"></i> 0271-646994
                        </a><br>
                        <a href="mailto:lpske.ft.uns.ac.id" class="text-decoration-none text-white">
                            <i class="fas fa-envelope me-2"></i> lpske.ft.uns.ac.id
                        </a>
                    </p>
                    <div class="social-links mt-3">
                        <a href="https://www.instagram.com/lpske_tiuns/" class="text-decoration-none"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@lpske_tiuns" class="text-decoration-none"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} LPSKE - Laboratorium Perancangan Sistem Kerja dan Ergonomi. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Livewire Scripts --}}
    @livewireScripts

    @stack('scripts')
    @stack('modals')
</body>
</html>
