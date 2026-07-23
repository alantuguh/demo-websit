<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPSKE - Laboratorium Perancangan Sistem Kerja dan Ergonomi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.css">

    {{-- Livewire Styles --}}
    @livewireStyles

    <style>
        html {
            scroll-behavior: smooth;
        }

        :root {
            --primary-color: rgba(82, 103, 132, 1);
            --primary-dark: #3f5066;
            --secondary-color: rgb(176, 99, 13);
            --accent-color: rgba(195, 208, 227, 1);
            --surface: #f7f9fb;
            --ink: #1f2937;
            --muted: #6b7280;
            --font-heading: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            --font-body: 'Inter', 'Segoe UI', sans-serif;
        }

        body {
            font-family: var(--font-body);
            color: var(--ink);
        }

        h1, h2, h3, h4, h5, h6,
        .navbar-brand, .btn, .fw-bold {
            font-family: var(--font-heading);
            letter-spacing: -0.01em;
        }

        /* Bold gradient accent for key highlighted words (uses existing brand colors only) */
        .text-gradient {
            background: linear-gradient(100deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* ===== Navbar ===== */
        .navbar {
            background-color: rgba(255, 255, 255, 0.92);
            backdrop-filter: saturate(180%) blur(8px);
            box-shadow: 0 1px 0 rgba(17, 24, 39, 0.06);
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
            transition: padding 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .navbar.navbar-scrolled {
            padding-top: 0.55rem;
            padding-bottom: 0.55rem;
            background-color: rgba(255, 255, 255, 0.97);
            box-shadow: 0 12px 28px rgba(17, 24, 39, 0.09);
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary-color) !important;
            transition: transform 0.25s ease;
        }

        .navbar-brand:hover {
            transform: translateY(-1px);
        }

        /* Nav links: text + animated highlight bar on hover/focus (no background pill, no blur) */
        .navbar-nav .nav-link {
            position: relative;
            color: var(--ink) !important;
            font-weight: 600;
            font-size: 0.92rem;
            padding: 0.55rem 1rem !important;
            border-radius: 0;
            transition: color 0.2s ease;
        }

        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 4px;
            width: 0;
            height: 3px;
            border-radius: 3px;
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
            transform: translateX(-50%);
            transition: width 0.35s cubic-bezier(0.65, 0, 0.35, 1);
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus,
        .navbar-nav .nav-link.active,
        .navbar-nav .dropdown:hover > .nav-link,
        .navbar-nav .dropdown.show > .nav-link {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link:hover::before,
        .navbar-nav .nav-link:focus::before,
        .navbar-nav .nav-link.active::before,
        .navbar-nav .dropdown:hover > .nav-link::before,
        .navbar-nav .dropdown.show > .nav-link::before {
            width: 55%;
        }

        .dropdown-menu {
            display: block !important; 
            opacity: 0;
            visibility: hidden;
            transform: translateY(-30px) scale(1);
            pointer-events: none;
            transition: opacity 0.2s cubic-bezier(1, 0, 0.2, 1),
                        transform 0.2s cubic-bezier(1, 0, 0.2, 1),
                        visibility 0.2s ease-in-out;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            pointer-events: auto;
            transition: opacity 0.3s cubic-bezier(0, 0, 0.2, 1),
                        transform 0.3s cubic-bezier(0, 0, 0.2, 1),
                        visibility 0.3s ease-out;
        }
        
        .dropdown-menu.show li:nth-child(1) { transition-delay: 0.05s; }
        .dropdown-menu.show li:nth-child(2) { transition-delay: 0.09s; }
        .dropdown-menu.show li:nth-child(3) { transition-delay: 0.13s; }
        .dropdown-menu.show li:nth-child(4) { transition-delay: 0.17s; }
        .dropdown-menu.show li:nth-child(5) { transition-delay: 0.21s; }
        .dropdown-menu.show li:nth-child(6) { transition-delay: 0.25s; }
        .dropdown-menu.show li:nth-child(7) { transition-delay: 0.29s; }
        .dropdown-menu.show li:nth-child(8) { transition-delay: 0.33s; }

        .dropdown-item {
            border-radius: 0.6rem;
            font-weight: 500;
            padding: 0.55rem 0.9rem;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .dropdown-item:hover {
            background: var(--surface);
            color: var(--primary-color);
            transition: background 0.5s ease, color 0.5s ease;
        }

        .dropdown-item.active, 
        .dropdown-item:active {
            background-color: var(--primary-color);
            color: #ffffff !important;
        }

        /* ===== Buttons ===== */
        .btn {
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-brand {
            background: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.75rem;
            transition: all 0.25s ease;
        }

        .btn-brand:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 16px 30px rgba(82, 103, 132, 0.35);
        }

        .btn-brand:active {
            transform: translateY(-1px);
        }

        .btn-outline-brand {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 50px;
            padding: 0.7rem 1.7rem;
            background: transparent;
            transition: all 0.25s ease;
        }

        .btn-outline-brand:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 14px 26px rgba(82, 103, 132, 0.25);
        }

        .btn-outline-brand:active {
            transform: translateY(-1px);
        }

        /* ===== Section helpers ===== */
        .eyebrow {
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.75rem;
        }

        .section-title {
            color: var(--ink);
            font-weight: 800;
        }

        .section-subtitle {
            color: var(--muted);
            max-width: 620px;
        }

        .section-title.text-center,
        .section-subtitle.mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .bg-surface {
            background: var(--surface);
        }

        /* ===== Cards ===== */
        .card-flat {
            background: #fff;
            border: 1px solid var(--primary-color);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.12);
            border-radius: 1.1rem;
            transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease, border-color 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: 5% 0 10%
        }

        .card-flat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s ease;
        }

        .card-flat:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(82, 103, 132, 0.25);
            border-color: var(--secondary-color);
        }

        .card-flat:hover::before {
            transform: scaleX(1);
        }

        .icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(82, 103, 132, 0.1);
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        /* ===== List rows (e.g. Mata Kuliah) — drop shadow + bold accent line ===== */
        .list-row {
            display: flex;
            align-items: center;
            background: #fff;
            border-left: 4px solid var(--primary-color);
            border-radius: 0.5rem;
            padding: 0.55rem 0.9rem;
            margin-bottom: 0.55rem;
            box-shadow: 0 6px 14px rgba(17, 24, 39, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .list-row:last-child {
            margin-bottom: 0;
        }

        .list-row:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 22px rgba(17, 24, 39, 0.13);
        }

        .list-row-accent {
            border-left-color: var(--secondary-color);
        }

        /* ===== Image accents — drop shadow + bold accent border/line ===== */
        .img-hero-accent {
            box-shadow: 0 20px 45px rgba(17, 24, 39, 0.18);
            border: 4px solid var(--accent-color);
        }

        .img-thumb-accent {
            box-shadow: 0 10px 24px rgba(17, 24, 39, 0.14);
            border-bottom: 4px solid var(--secondary-color);
        }

        /* ===== 3D Hero Illustration (gradient icon cluster w/ float + gloss) ===== */
   

        .hero3d-stage {
            position: relative;
            width: 100%;
            max-width: 400px;
            aspect-ratio: 1 / 1;
            margin: 0 auto;
        }

        .hero3d-orb {
            position: absolute;
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .hero3d-orb.o1 { width: 230px; height: 230px; top: -8%; left: -12%; background: var(--accent-color); opacity: 0.55; }
        .hero3d-orb.o2 { width: 110px; height: 110px; bottom: -4%; right: -4%; background: var(--secondary-color); opacity: 0.16; }

        .hero3d-badge {
            position: absolute;
            top: 2%;
            right: 0;
            z-index: 5;
            background: var(--secondary-color);
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.5em 1.15em;
            border-radius: 50px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
        }

        .hero3d-tile {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 30%;
            box-shadow:
                0 22px 40px -8px rgba(17, 24, 39, 0.35),
                inset 0 2px 3px rgba(255, 255, 255, 0.45),
                inset 0 -10px 16px rgba(0, 0, 0, 0.15);
            z-index: 2;
        }

        .hero3d-tile::after {
            content: '';
            position: absolute;
            top: 12%;
            left: 16%;
            width: 34%;
            height: 20%;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            filter: blur(3px);
            transform: rotate(-20deg);
            pointer-events: none;
        }

        .hero3d-tile i {
            color: #fff;
            filter: drop-shadow(0 3px 4px rgba(0, 0, 0, 0.28));
            position: relative;
            z-index: 1;
        }

        .hero3d-tile.g-primary { background: radial-gradient(circle at 32% 26%, #8ea0bc 0%, var(--primary-color) 55%, var(--primary-dark) 100%); }
        .hero3d-tile.g-secondary { background: radial-gradient(circle at 32% 26%, #e6a751 0%, var(--secondary-color) 58%, #7c4909 100%); }
        .hero3d-tile.g-accent { background: radial-gradient(circle at 32% 26%, #eef2f8 0%, var(--accent-color) 60%, #9fb2ce 100%); }
        .hero3d-tile.g-accent i { color: var(--primary-color); filter: drop-shadow(0 2px 2px rgba(255, 255, 255, 0.5)); }
        .hero3d-tile.g-light { background: radial-gradient(circle at 32% 26%, #ffffff 0%, #eef2f7 55%, var(--accent-color) 100%); }
        .hero3d-tile.g-light i { color: var(--secondary-color); filter: none; }

        .hero3d-tile.tile-main { width: 48%; height: 48%; left: 26%; top: 24%; font-size: 2.6rem; z-index: 3; animation: hero3d-float-1 6.5s ease-in-out infinite; }
        .hero3d-tile.tile-main i { font-size: 2.6rem; }

        .hero3d-tile.tile-1 { width: 30%; height: 30%; left: -4%; top: 8%; font-size: 1.5rem; animation: hero3d-float-2 5s ease-in-out infinite; animation-delay: 0.3s; }
        .hero3d-tile.tile-1 i { font-size: 1.5rem; }

        .hero3d-tile.tile-2 { width: 27%; height: 27%; right: -3%; top: 10%; font-size: 1.3rem; animation: hero3d-float-3 5.5s ease-in-out infinite; animation-delay: 0.9s; }
        .hero3d-tile.tile-2 i { font-size: 1.3rem; }

        .hero3d-tile.tile-3 { width: 26%; height: 26%; left: 8%; bottom: -2%; font-size: 1.25rem; z-index: 4; animation: hero3d-float-4 5.2s ease-in-out infinite; animation-delay: 1.4s; }
        .hero3d-tile.tile-3 i { font-size: 1.25rem; }

        @keyframes hero3d-float-1 { 0%, 100% { transform: translateY(0) rotate(-4deg); } 50% { transform: translateY(-14px) rotate(-6deg); } }
        @keyframes hero3d-float-2 { 0%, 100% { transform: translateY(0) rotate(8deg); } 50% { transform: translateY(-10px) rotate(10deg); } }
        @keyframes hero3d-float-3 { 0%, 100% { transform: translateY(0) rotate(-6deg); } 50% { transform: translateY(-12px) rotate(-8deg); } }
        @keyframes hero3d-float-4 { 0%, 100% { transform: translateY(0) rotate(5deg); } 50% { transform: translateY(-9px) rotate(7deg); } }

        @media (max-width: 991.98px) {
            .hero3d-stage { max-width: 300px; margin-top: 1.5rem; }
        }

        @media (prefers-reduced-motion: reduce) {
            .hero3d-tile { animation: none; }
        }

        /* ===== Stats ===== */
        .stat-number {
            font-family: var(--font-heading);
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--primary-color);
            line-height: 1;
            font-variant-numeric: tabular-nums;
        }

        .stat-label {
            font-size: 0.82rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 0.4rem;
        }

        /* ===== Partner / collaborator logo marquee (auto-scrolling) ===== */
        .logo-marquee {
            overflow: hidden;
            width: 100%;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
            mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
        }

        .logo-track {
            display: flex;
            align-items: center;
            gap: 2.25rem;
            width: max-content;
            animation: logo-scroll 26s linear infinite;
        }

        .logo-marquee:hover .logo-track {
            animation-play-state: paused;
        }

        @keyframes logo-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .partner-avatar {
            flex: 0 0 auto;
            width: 88px;
            height: 88px;
            border-radius: 50%;
            overflow: hidden;
            background: #fff;
            border: 3px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.18);
            filter: grayscale(65%);
            opacity: 0.85;
            transition: all 0.25s ease;
        }

        .partner-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .partner-avatar:hover {
            filter: grayscale(0%);
            opacity: 1;
            transform: translateY(-4px);
        }

        @media (prefers-reduced-motion: reduce) {
            .logo-track {
                animation: none;
            }
        }

        /* ===== Floating quick contact ===== */
        .floating-contact {
            position: fixed;
            right: 24px;
            bottom: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--secondary-color);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25);
            z-index: 1050;
            transition: transform 0.25s ease, color 0.25s ease;
            animation: pulse-ring 2.6s ease-in-out infinite;
        }

        .floating-contact:hover {
            color: #fff;
            transform: translateY(-4px) scale(1.06);
            animation-play-state: paused;
        }

        @keyframes pulse-ring {
            0%, 100% {
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25), 0 0 0 0 rgba(176, 99, 13, 0.45);
            }
            50% {
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25), 0 0 0 12px rgba(176, 99, 13, 0);
            }
        }

        /* ===== Footer ===== */
        footer {
            background: #16202b;
            color: rgba(255, 255, 255, 0.85);
            padding: 64px 0 28px;
        }

        footer h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 22px;
            position: relative;
            padding-bottom: 10px;
            text-transform: uppercase;
            font-size: 1rem;
            letter-spacing: 1px;
        }

        footer h5::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 42px;
            height: 2px;
            background-color: var(--secondary-color);
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 6px;
        }

        footer p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: all 0.2s ease;
        }

        .social-links a:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }

        footer hr {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 30px 0 20px;
        }

        footer .text-center {
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.88rem;
        }
        .bg-particles {
            background-color: rgba(195, 208, 227, 0.25); 
            background-image: 
                radial-gradient(rgba(176, 99, 13, 0.25) 2.5px, transparent 3px),
                radial-gradient(rgba(82, 103, 132, 0.2) 2px, transparent 4px);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
            position: relative;
        }
        
        .wave-divider-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: translateY(1px); 
        }

        .wave-divider-bottom svg {
            display: block;
            width: calc(100% + 1.3px);
            height: 25px;
        }

        @media (min-width: 992px) {
            .wave-divider-bottom svg {
                height: 40px;
                width: 120%;
            }
        }

    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background: linear-gradient(180deg, rgba(195, 208, 227, 0.75) 25%, #aebfda 100%);">
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
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}#home">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('asisten-laboratorium*', 'kepala-laboratorium*', 'dosen-laboratorium*') ? 'active' : ''}}" href="#" id="asistenDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Asisten Laboratorium
                        </a>
                        <ul class="dropdown-menu" style="background: linear-gradient(180deg, rgba(195, 208, 227, 0.9) 75%, #d9dde4 100%)"aria-labelledby="asistenDropdown">
                            <li><a class="dropdown-item {{ request()->routeIs('asisten-laboratorium') && !request('angkatan') ? 'active' : '' }}" href="{{ route('asisten-laboratorium') }}">Semua Asisten</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item {{ request('angkatan') == 2020 ? 'active' : '' }}" href="{{ route('asisten-laboratorium', ['angkatan' => 2020]) }}">Angkatan 2020</a></li>
                            <li><a class="dropdown-item {{ request('angkatan') == 2019 ? 'active' : '' }}" href="{{ route('asisten-laboratorium', ['angkatan' => 2019]) }}">Angkatan 2019</a></li>
                            <li><a class="dropdown-item {{ request('angkatan') == 2018 ? 'active' : '' }}" href="{{ route('asisten-laboratorium', ['angkatan' => 2018]) }}">Angkatan 2018</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item {{ request()->routeIs('kepala-laboratorium') ? 'active' : '' }}" href="{{ route('kepala-laboratorium') }}">Kepala Laboratorium</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('dosen-laboratorium') ? 'active' : '' }}" href="{{ route('dosen-laboratorium') }}">Dosen Laboratorium</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('prestasi-kegiatan.index') ? 'active' : '' }}" href="{{ route('prestasi-kegiatan.index') }}">Prestasi & Kegiatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('katalog-karya.index') ? 'active' : '' }}" href="{{ route('katalog-karya.index') }}">Katalog Karya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('proyek-laboratorium.index') ? 'active' : '' }}" href="{{ route('proyek-laboratorium.index') }}">Proyek Laboratorium</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.alumni.index') ? 'active' : '' }}" href="{{ route('public.alumni.index') }}">Alumni</a>
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
                        <a href="{{ route('prestasi-kegiatan.index') }}">Prestasi & Kegiatan</a>
                        <a href="{{ route('proyek-laboratorium.index') }}">Proyek Laboratorium</a>
                        <a href="{{ route('public.alumni.index') }}">Alumni</a>
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

    <!-- Floating Quick Contact -->
    <a href="tel:0271-646994" class="floating-contact" title="Hubungi LPSKE">
        <i class="fas fa-phone"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Scroll-reveal animations (fade/slide-in as sections enter the viewport)
            if (window.AOS) {
                AOS.init({
                    duration: 700,
                    easing: 'ease-out-cubic',
                    once: true,
                    offset: 60,
                });
            }

            // Solidify / compact the navbar once the page is scrolled
            var navbar = document.querySelector('.navbar');
            if (navbar) {
                var onScroll = function () {
                    navbar.classList.toggle('navbar-scrolled', window.scrollY > 24);
                };
                onScroll();
                window.addEventListener('scroll', onScroll, { passive: true });
            }

            // Close the mobile menu automatically after a link is tapped
            var navCollapseEl = document.getElementById('navbarNav');
            if (navCollapseEl && window.bootstrap) {
                var bsCollapse = window.bootstrap.Collapse.getOrCreateInstance(navCollapseEl, { toggle: false });
                navCollapseEl.querySelectorAll('.nav-link:not(.dropdown-toggle), .dropdown-item').forEach(function (link) {
                    link.addEventListener('click', function () {
                        if (navCollapseEl.classList.contains('show')) {
                            bsCollapse.hide();
                        }
                    });
                });
            }

            // Animated count-up for the stats strip
            var counters = document.querySelectorAll('.stat-number[data-count]');
            var animateCounter = function (el) {
                var target = parseInt(el.getAttribute('data-count'), 10) || 0;
                var suffix = el.getAttribute('data-suffix') || '';
                var duration = 1400;
                var start = null;

                var step = function (timestamp) {
                    if (!start) start = timestamp;
                    var progress = Math.min((timestamp - start) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.floor(eased * target) + suffix;
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    } else {
                        el.textContent = target + suffix;
                    }
                };
                window.requestAnimationFrame(step);
            };

            if (counters.length) {
                if ('IntersectionObserver' in window) {
                    var observer = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                animateCounter(entry.target);
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.4 });
                    counters.forEach(function (el) { observer.observe(el); });
                } else {
                    counters.forEach(animateCounter);
                }
            }
        });
    </script>

    {{-- Livewire Scripts --}}
    @livewireScripts

    @stack('scripts')
    @stack('modals')
</body>
</html>
