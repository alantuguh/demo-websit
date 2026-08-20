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
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.css">

    {{-- Livewire Styles --}}
    @livewireStyles

    <style>
        html {
            scroll-behavior: smooth;
        }

        :root {
            /* ===== Brand palette — futuristic glass ===================================
               Two families do all the work: an electric blue (structure, links, primary
               actions) and a cyan-teal (accents, highlights). Each has a *text-safe*
               value used wherever the colour carries words, and a *bright* value used
               only for fills, glows and gradients where contrast is not a concern.     */
            --primary-color: #2f5fe0;      /* 5.5:1 on white — safe for body text */
            --primary-bright: #4f7df3;     /* fills + gradients only */
            --primary-dark: #1e3fa8;
            --secondary-color: #0e7490;    /* 5.4:1 on white — safe for body text */
            --secondary-bright: #22d3ee;   /* glow + gradients only */
            --violet-bright: #a78bfa;      /* third aurora note, never used for text */
            --accent-color: #c7d7f5;
            --surface: #ffffff;
            --ink: #0b1220;
            --muted: #46536b;              /* 7.7:1 on white */

            --font-heading: 'Space Grotesk', 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            --font-body: 'Inter', 'Segoe UI', sans-serif;
            --font-mono: ui-monospace, 'SFMono-Regular', 'JetBrains Mono', Menlo, monospace;

            /* ===== Design tokens: one scale, reused everywhere =====
               Swap a value here and it updates every card, button, badge. */
            --radius-sm: 0.6rem;
            --radius-md: 0.9rem;
            --radius-lg: 1.25rem;
            --radius-pill: 999px;

            /* ===== Glass tokens =======================================================
               Every frosted surface reads from these four values, so the whole site can
               be made more or less "glassy" from one place. --glass-edge is the cool rim
               light that separates a panel from the aurora behind it.                   */
            --glass-bg: rgba(255, 255, 255, 0.58);
            --glass-bg-strong: rgba(255, 255, 255, 0.80);
            --glass-border: rgba(255, 255, 255, 0.70);
            --glass-edge: rgba(47, 95, 224, 0.16);
            --glass-blur: 18px;

            --hairline: rgba(20, 40, 90, 0.10);

            --shadow-rest: 0 8px 30px rgba(20, 40, 90, 0.10),
                           inset 0 1px 0 rgba(255, 255, 255, 0.65);
            --shadow-hover: 0 22px 50px rgba(20, 40, 90, 0.18),
                            inset 0 1px 0 rgba(255, 255, 255, 0.85);
            --shadow-brand: 0 18px 38px rgba(47, 95, 224, 0.32);
            --glow-cyan: 0 0 0 1px rgba(34, 211, 238, 0.35),
                         0 12px 34px rgba(34, 211, 238, 0.28);
        }

        /* ===== Base + aurora ======================================================
           The aurora is a single fixed layer behind everything. It is what the frosted
           panels actually blur — without it, "glass" would just look like flat white. */
        body {
            font-family: var(--font-body);
            color: var(--ink);
            background-color: var(--surface);
        }

        /* Aurora sengaja ditinggalkan sangat tipis: cukup untuk menghindari putih
           yang benar-benar datar, tapi tetap terbaca sebagai latar putih. Yang
           memberi kedalaman sekarang adalah kanvas plexus di atas lapisan ini. */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background:
                radial-gradient(48rem 32rem at 10% -8%, rgba(79, 125, 243, 0.07), transparent 62%),
                radial-gradient(40rem 28rem at 94% 4%, rgba(34, 211, 238, 0.06), transparent 64%),
                radial-gradient(44rem 32rem at 72% 96%, rgba(167, 139, 250, 0.05), transparent 62%),
                var(--surface);
        }

        /* ===== Kanvas plexus =====================================================
           Satu kanvas tetap untuk seluruh halaman (bukan satu per section), di
           atas aurora tapi di bawah semua konten. Titik dan garisnya digambar
           oleh skrip di dekat penutup halaman. */
        .plexus-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            display: block;
            pointer-events: none;
        }

        @media (prefers-reduced-motion: reduce) {
            .plexus-bg {
                /* Skrip menggambar satu frame diam; kanvasnya tetap tampil. */
                opacity: 0.85;
            }
        }

        h1, h2, h3, h4, h5, h6,
        .navbar-brand, .btn, .fw-bold {
            font-family: var(--font-heading);
            letter-spacing: -0.015em;
        }

        /* Bold gradient accent for key highlighted words */
        .text-gradient {
            background: linear-gradient(100deg, var(--primary-color) 0%, var(--secondary-bright) 60%, var(--violet-bright) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* ===== Reusable frosted-panel recipe =====
           .glass-panel is the single source of truth; components extend it. */
        .glass-panel {
            background: var(--glass-bg);
            -webkit-backdrop-filter: blur(var(--glass-blur)) saturate(160%);
            backdrop-filter: blur(var(--glass-blur)) saturate(160%);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-rest), 0 0 0 1px var(--glass-edge);
            border-radius: var(--radius-lg);
        }

        /* ===== Navbar ===== */
        .navbar {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.72), rgba(233, 240, 255, 0.58));
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: 0 1px 0 var(--glass-edge), 0 10px 30px rgba(20, 40, 90, 0.06);
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
            transition: padding 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }

        /* Scanline of light along the bottom edge — the one overt "sci-fi" flourish */
        .navbar::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--secondary-bright), var(--primary-bright), transparent);
            opacity: 0.55;
        }

        .navbar.navbar-scrolled {
            padding-top: 0.55rem;
            padding-bottom: 0.55rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.88), rgba(233, 240, 255, 0.74));
            box-shadow: 0 1px 0 var(--glass-edge), 0 16px 34px rgba(20, 40, 90, 0.10);
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary-color) !important;
            transition: transform 0.25s ease;
        }

        .navbar-brand:hover {
            transform: translateY(-1px);
        }

        /* Nav links: text + animated highlight bar on hover/focus */
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
            background: linear-gradient(90deg, var(--secondary-bright), var(--primary-bright));
            box-shadow: 0 0 12px rgba(34, 211, 238, 0.7);
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

        /* ===== Dropdown ===== */
        .dropdown-menu {
            background: var(--glass-bg-strong);
            -webkit-backdrop-filter: blur(var(--glass-blur)) saturate(170%);
            backdrop-filter: blur(var(--glass-blur)) saturate(170%);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-md);
            box-shadow: 0 18px 44px rgba(20, 40, 90, 0.16), 0 0 0 1px var(--glass-edge);
            padding: 0.5rem;
        }

        /* Fancy fade/scale dropdown transition — desktop only (matches navbar-expand-lg's
           breakpoint, where Bootstrap switches the dropdown to position:absolute so it
           floats over the page). Below that, the menu is position:static and stacked
           inside the collapsed mobile nav, so forcing display:block here would keep
           reserving empty vertical space even while "hidden" — that was the gap. */
        @media (min-width: 992px) {
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
        }

        /* Mobile — plain, simple accordion-style toggle inside the collapsed menu */
        @media (max-width: 991.98px) {
            .dropdown-menu {
                display: none;
                border: none;
                box-shadow: none;
                background: transparent !important;
                -webkit-backdrop-filter: none;
                backdrop-filter: none;
                padding-left: 0.75rem;
            }

            .dropdown-menu.show {
                display: block;
                animation: hero3d-dropdown-mobile-in 0.25s ease-out;
            }

            @keyframes hero3d-dropdown-mobile-in {
                from { opacity: 0; transform: translateY(-6px); }
                to { opacity: 1; transform: translateY(0); }
            }
        }

        .dropdown-item {
            border-radius: var(--radius-sm);
            font-weight: 500;
            padding: 0.55rem 0.9rem;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(79, 125, 243, 0.12);
            color: var(--primary-color);
            transition: background 0.5s ease, color 0.5s ease;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            background: linear-gradient(100deg, var(--primary-color), var(--primary-bright));
            color: #ffffff !important;
        }

        /* ===== Buttons ===== */
        .btn {
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(100deg, var(--primary-color), var(--primary-bright));
            border-color: transparent;
        }

        .btn-primary:hover {
            background: linear-gradient(100deg, var(--primary-dark), var(--primary-color));
            border-color: transparent;
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
            position: relative;
            background: linear-gradient(100deg, var(--primary-color) 0%, var(--primary-bright) 55%, var(--secondary-bright) 130%);
            color: #fff;
            border: none;
            border-radius: var(--radius-pill);
            padding: 0.75rem 1.75rem;
            box-shadow: 0 10px 24px rgba(47, 95, 224, 0.28);
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        /* Sheen that sweeps across on hover */
        .btn-brand::after {
            content: '';
            position: absolute;
            top: 0;
            left: -60%;
            width: 40%;
            height: 100%;
            background: linear-gradient(100deg, transparent, rgba(255, 255, 255, 0.55), transparent);
            transform: skewX(-18deg);
            transition: left 0.55s ease;
        }

        .btn-brand:hover {
            color: #fff;
            transform: translateY(-3px);
            box-shadow: var(--shadow-brand), var(--glow-cyan);
        }

        .btn-brand:hover::after {
            left: 120%;
        }

        .btn-brand:active {
            transform: translateY(-1px);
        }

        .btn-outline-brand {
            border: 1px solid var(--glass-border);
            color: var(--primary-color);
            border-radius: var(--radius-pill);
            padding: 0.7rem 1.7rem;
            background: var(--glass-bg);
            -webkit-backdrop-filter: blur(12px) saturate(160%);
            backdrop-filter: blur(12px) saturate(160%);
            box-shadow: 0 0 0 1px var(--glass-edge), 0 6px 18px rgba(20, 40, 90, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease, color 0.25s ease;
        }

        .btn-outline-brand:hover {
            background: linear-gradient(100deg, var(--primary-color), var(--primary-bright));
            color: #fff;
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: var(--shadow-brand);
        }

        .btn-outline-brand:active {
            transform: translateY(-1px);
        }

        /* ===== Section helpers ===== */
        .eyebrow {
            display: inline-block;
            font-family: var(--font-mono);
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-size: 0.74rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.75rem;
        }

        /* Small leading tick, like a readout label */
        .eyebrow::before {
            content: '';
            display: inline-block;
            width: 1.6rem;
            height: 2px;
            margin-right: 0.6rem;
            vertical-align: middle;
            background: linear-gradient(90deg, var(--secondary-bright), var(--primary-bright));
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
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.55), rgba(239, 243, 252, 0.30));
        }

        /* Bootstrap's bg-light is opaque white by default and would block the aurora */
        .bg-light {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.62), rgba(239, 243, 252, 0.38)) !important;
        }

        /* ===== Layout utility (replaces repeated inline padding-top/bottom) ===== */
        .section-py {
            padding-top: 6rem;
            padding-bottom: 6rem;
        }

        /* ===== Page hero band =====================================================
           Replaces the gradient+photo inline style that was copy-pasted into eight
           different page templates. Edit the band once, here. */
        .page-hero {
            position: relative;
            overflow: hidden;
            padding: 110px 0 90px;
            background:
                linear-gradient(180deg, rgba(20, 40, 90, 0.34) 0%, rgba(47, 95, 224, 0.40) 55%, rgba(14, 116, 144, 0.48) 100%),
                var(--hero-photo, none),
                linear-gradient(160deg, #1b2a6b, #0e7490);
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        /* Aurora bloom + faint tech grid layered over the photo */
        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(30rem 20rem at 8% 12%, rgba(34, 211, 238, 0.38), transparent 60%),
                radial-gradient(28rem 20rem at 90% 82%, rgba(167, 139, 250, 0.34), transparent 62%),
                repeating-linear-gradient(90deg, rgba(255, 255, 255, 0.07) 0 1px, transparent 1px 64px),
                repeating-linear-gradient(0deg, rgba(255, 255, 255, 0.07) 0 1px, transparent 1px 64px);
        }

        .page-hero > * {
            position: relative;
            z-index: 1;
        }

        /* ===== Lapisan video latar hero (lihat partials/hero-video) ===========
           Selector sengaja dibuat lebih spesifik daripada `.page-hero > *` di
           atas — aturan itu menaikkan SEMUA anak langsung ke z-index 1, dan
           tanpa penimpaan ini video akan menutupi teks hero. */
        .page-hero .page-hero-media {
            position: absolute;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .page-hero-media video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            /* Landing tidak lagi memakai foto lab, jadi video ini satu-satunya
               citra di hero — opasitasnya dinaikkan sedikit dari 0.35 agar tetap
               terbaca di atas gradien, tapi masih samar di belakang teks.
               Kalau perlu disetel, cukup ubah satu angka ini. */
            opacity: 0.45;
            filter: saturate(0.85);
        }

        /* Peredup di atas video supaya kontras teks hero tidak turun */
        .page-hero-media::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                rgba(11, 20, 48, 0.30) 0%,
                rgba(20, 40, 110, 0.22) 55%,
                rgba(14, 116, 144, 0.28) 100%);
        }

        @media (prefers-reduced-motion: reduce) {
            .page-hero-media {
                display: none;
            }
        }

        .page-hero .section-title,
        .page-hero h1,
        .page-hero h2 {
            color: #fff;
            text-shadow: 0 2px 18px rgba(6, 16, 42, 0.45);
        }

        .page-hero .section-subtitle,
        .page-hero p {
            color: rgba(255, 255, 255, 0.90);
        }

        .page-hero .eyebrow {
            color: #a5f3fc;
        }

        .page-hero .eyebrow::before {
            background: linear-gradient(90deg, #a5f3fc, rgba(255, 255, 255, 0.6));
        }

        .page-hero .badge-soft {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.35);
        }

        .page-hero .btn-outline-brand {
            color: #fff;
            border-color: rgba(255, 255, 255, 0.55);
            background: rgba(255, 255, 255, 0.14);
        }

        .page-hero .btn-outline-brand:hover {
            color: var(--primary-dark);
            background: #fff;
        }

        /* On the dark band the blue half of the gradient disappears, so the highlight
           runs cyan -> white instead. */
        .page-hero .text-gradient {
            background: linear-gradient(100deg, #a5f3fc 0%, #ffffff 55%, #c4b5fd 100%);
            -webkit-background-clip: text;
            background-clip: text;
        }

        /* ===== Deep band =========================================================
           A dark aurora section used to break up the light page and anchor it —
           same family as the hero, reusable on any section via .band-deep. */
        .band-deep {
            position: relative;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.92);
            background:
                radial-gradient(38rem 22rem at 14% 8%, rgba(47, 95, 224, 0.55), transparent 62%),
                radial-gradient(32rem 20rem at 86% 90%, rgba(14, 116, 144, 0.55), transparent 62%),
                #0b1430;
        }

        .band-deep::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                repeating-linear-gradient(90deg, rgba(255, 255, 255, 0.05) 0 1px, transparent 1px 58px),
                repeating-linear-gradient(0deg, rgba(255, 255, 255, 0.05) 0 1px, transparent 1px 58px);
        }

        .band-deep h1,
        .band-deep h2,
        .band-deep h3,
        .band-deep h4,
        .band-deep h5 {
            color: #fff;
        }

        .band-deep p {
            color: rgba(255, 255, 255, 0.82);
        }

        .band-deep .eyebrow {
            color: #a5f3fc;
        }

        .band-deep .eyebrow::before {
            background: linear-gradient(90deg, #a5f3fc, rgba(255, 255, 255, 0.55));
        }

        .band-deep .partner-avatar {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.35);
        }

        /* ===== Badge utilities ===== */
        .badge-brand,
        .badge-accent {
            font-size: 0.75em;
            border-radius: var(--radius-pill);
            padding: 0.45em 0.9em;
            font-weight: 700;
        }

        .badge-brand {
            background: linear-gradient(100deg, var(--primary-color), var(--primary-bright));
            color: #fff;
        }

        .badge-accent {
            background: linear-gradient(100deg, var(--secondary-color), var(--secondary-bright));
            color: #fff;
        }

        .badge-soft {
            background: rgba(79, 125, 243, 0.12);
            color: var(--primary-color);
            border: 1px solid rgba(79, 125, 243, 0.22);
            border-radius: var(--radius-pill);
            padding: 0.45em 0.9em;
            font-weight: 700;
            font-size: 0.78em;
        }

        /* ===== Cards — the main frosted surface ===== */
        .card-flat {
            background: var(--glass-bg);
            -webkit-backdrop-filter: blur(var(--glass-blur)) saturate(160%);
            backdrop-filter: blur(var(--glass-blur)) saturate(160%);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-rest), 0 0 0 1px var(--glass-edge);
            border-radius: var(--radius-lg);
            transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease, border-color 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: 0 0 10%;
        }

        .card-flat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-bright), var(--primary-bright), var(--violet-bright));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s ease;
            z-index: 2;
        }

        .card-flat:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover), 0 0 0 1px rgba(34, 211, 238, 0.35);
            border-color: rgba(255, 255, 255, 0.9);
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
            background: linear-gradient(145deg, rgba(79, 125, 243, 0.16), rgba(34, 211, 238, 0.16));
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8), 0 6px 16px rgba(20, 40, 90, 0.10);
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        /* ===== List rows (e.g. Mata Kuliah) ===== */
        .list-row {
            display: flex;
            align-items: center;
            background: var(--glass-bg);
            -webkit-backdrop-filter: blur(12px) saturate(150%);
            backdrop-filter: blur(12px) saturate(150%);
            border: 1px solid var(--glass-border);
            border-left: 3px solid var(--primary-bright);
            border-radius: var(--radius-sm);
            padding: 0.55rem 0.9rem;
            margin-bottom: 0.55rem;
            box-shadow: 0 6px 18px rgba(20, 40, 90, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .list-row:last-child {
            margin-bottom: 0;
        }

        .list-row:hover {
            transform: translateX(5px);
            border-left-color: var(--secondary-bright);
            box-shadow: 0 14px 30px rgba(20, 40, 90, 0.14);
        }

        .list-row-accent {
            border-left-color: var(--secondary-bright);
        }

        /* ===== Image accents ===== */
        .img-hero-accent {
            box-shadow: 0 24px 55px rgba(20, 40, 90, 0.28), 0 0 0 1px rgba(34, 211, 238, 0.30);
            border: 4px solid rgba(255, 255, 255, 0.75);
        }

        .img-thumb-accent {
            box-shadow: 0 10px 24px rgba(20, 40, 90, 0.16);
            border-bottom: 3px solid var(--secondary-bright);
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .card-flat:hover .img-thumb-accent {
            transform: scale(1.06);
        }

        /* ===== Person card (Asisten Laboratorium) ===== */
        .person-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 0.35rem;
        }

        .person-avatar {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            color: #fff;
            background: linear-gradient(145deg, var(--primary-bright), var(--primary-dark) 70%, var(--secondary-color));
            box-shadow: 0 10px 24px rgba(47, 95, 224, 0.30), inset 0 1px 0 rgba(255, 255, 255, 0.45);
            margin-bottom: 0.6rem;
        }

        .person-name {
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 0.15rem;
        }

        .person-role {
            color: var(--muted);
            font-size: 0.85rem;
            margin-bottom: 0.9rem;
        }

        .person-meta {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.4rem;
        }

        .person-meta .badge-soft {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
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
            filter: blur(6px);
        }

        .hero3d-orb.o1 { width: 230px; height: 230px; top: -8%; left: -12%; background: radial-gradient(circle, rgba(34, 211, 238, 0.75), transparent 70%); opacity: 0.8; }
        .hero3d-orb.o2 { width: 110px; height: 110px; bottom: -4%; right: -4%; background: radial-gradient(circle, rgba(167, 139, 250, 0.75), transparent 70%); opacity: 0.7; }

        .hero3d-badge {
            position: absolute;
            top: 2%;
            right: 0;
            z-index: 5;
            background: linear-gradient(100deg, var(--secondary-color), var(--secondary-bright));
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.5em 1.15em;
            border-radius: 50px;
            box-shadow: 0 12px 28px rgba(14, 116, 144, 0.45);
        }

        .hero3d-tile {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 30%;
            box-shadow:
                0 22px 40px -8px rgba(20, 40, 90, 0.38),
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

        .hero3d-tile.g-primary { background: radial-gradient(circle at 32% 26%, #8fb0ff 0%, var(--primary-bright) 55%, var(--primary-dark) 100%); }
        .hero3d-tile.g-secondary { background: radial-gradient(circle at 32% 26%, #7ee9fb 0%, var(--secondary-bright) 55%, var(--secondary-color) 100%); }
        .hero3d-tile.g-accent { background: radial-gradient(circle at 32% 26%, #f2f6ff 0%, var(--accent-color) 60%, #9fb2ce 100%); }
        .hero3d-tile.g-accent i { color: var(--primary-color); filter: drop-shadow(0 2px 2px rgba(255, 255, 255, 0.5)); }
        .hero3d-tile.g-light { background: radial-gradient(circle at 32% 26%, #ffffff 0%, #eef4ff 55%, var(--accent-color) 100%); }
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

        /* Slow continuous spin — only the gear-ring layer, the figure on top stays still */
        .hero3d-tile.tile-main {
            overflow: visible;
        }

        .hero3d-tile.tile-main .hero3d-gear-ring,
        .hero3d-tile.tile-main .hero3d-gear-figure {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .hero3d-tile.tile-main .hero3d-gear-ring {
            animation: hero3d-gear-spin 16s linear infinite;
            transform-origin: 50% 50%;
        }

        @keyframes hero3d-gear-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 991.98px) {
            .hero3d-stage { max-width: 300px; margin-top: 1.5rem; }
        }

        /* ===== Stats ===== */
        .stat-number {
            font-family: var(--font-heading);
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1;
            font-variant-numeric: tabular-nums;
            background: linear-gradient(100deg, var(--primary-color), var(--secondary-bright));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-label {
            font-family: var(--font-mono);
            font-size: 0.78rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.12em;
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
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 22px rgba(20, 40, 90, 0.18);
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
            box-shadow: 0 14px 30px rgba(20, 40, 90, 0.22), var(--glow-cyan);
        }

        /* ===== Produk unggulan — kartu video berjalan ============================
           Jalur bergerak dari KIRI ke KANAN: keyframe berangkat dari -50% menuju 0.
           Daftar kartu dirender dua kali, sehingga pada saat translate mencapai 0
           salinan kedua persis menempati posisi awal — putarannya tidak terlihat
           menyambung. */
        .product-marquee {
            overflow: hidden;
            width: 100%;
            padding: 0.75rem 0 1.25rem;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 7%, #000 93%, transparent 100%);
            mask-image: linear-gradient(90deg, transparent 0%, #000 7%, #000 93%, transparent 100%);
        }

        .product-track {
            display: flex;
            align-items: stretch;
            gap: 1.5rem;
            width: max-content;
            animation: product-scroll 70s linear infinite;
        }

        @keyframes product-scroll {
            from { transform: translateX(-50%); }
            to { transform: translateX(0); }
        }

        /* Berhenti saat disentuh tetikus atau saat ada elemen di dalamnya yang
           menerima fokus keyboard — tanpa ini, tautan mustahil diklik. */
        .product-marquee:hover .product-track,
        .product-marquee:focus-within .product-track {
            animation-play-state: paused;
        }

        .product-card {
            flex: 0 0 auto;
            width: 320px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-radius: var(--radius-lg);
            background: var(--glass-bg);
            -webkit-backdrop-filter: blur(var(--glass-blur)) saturate(160%);
            backdrop-filter: blur(var(--glass-blur)) saturate(160%);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-rest), 0 0 0 1px var(--glass-edge);
            transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover), 0 0 0 1px rgba(34, 211, 238, 0.35);
        }

        .product-media {
            position: relative;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: linear-gradient(140deg, var(--primary-dark), var(--secondary-color));
        }

        .product-media video,
        .product-media > img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Kartu tanpa video: logo atau ikon di atas gradien aurora */
        .product-media-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background:
                radial-gradient(18rem 12rem at 22% 18%, rgba(34, 211, 238, 0.40), transparent 62%),
                radial-gradient(16rem 11rem at 82% 84%, rgba(167, 139, 250, 0.36), transparent 62%);
        }

        .product-media-empty img {
            width: auto;
            max-width: 62%;
            height: 56%;
            object-fit: contain;
            filter: drop-shadow(0 6px 14px rgba(6, 16, 42, 0.45));
        }

        .product-media-empty i {
            font-size: 2.6rem;
            color: rgba(255, 255, 255, 0.92);
            filter: drop-shadow(0 4px 10px rgba(6, 16, 42, 0.45));
        }

        .product-flag {
            position: absolute;
            top: 0.7rem;
            left: 0.7rem;
            z-index: 2;
            font-family: var(--font-mono);
            font-size: 0.64rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            font-weight: 700;
            padding: 0.4em 0.8em;
            border-radius: var(--radius-pill);
            background: linear-gradient(100deg, var(--secondary-color), var(--secondary-bright));
            color: #fff;
            box-shadow: 0 6px 16px rgba(14, 116, 144, 0.45);
        }

        .product-body {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
            padding: 1rem 1.15rem 1.25rem;
        }

        .product-title {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.05rem;
            line-height: 1.3;
            margin: 0;
            color: var(--ink);
        }

        .product-desc {
            margin: 0;
            flex: 1;
            font-size: 0.88rem;
            line-height: 1.55;
            color: var(--muted);
        }

        .product-desc-empty {
            font-style: italic;
            opacity: 0.7;
        }

        .product-link {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--primary-color);
            text-decoration: none;
        }

        .product-link:hover {
            color: var(--secondary-color);
        }

        .product-link i {
            transition: transform 0.2s ease;
        }

        .product-link:hover i {
            transform: translateX(3px);
        }

        @media (max-width: 575.98px) {
            .product-card { width: 270px; }
        }

        /* ===== Modul VR — badge status & tautan ruang =========================
           Dipakai oleh partials/vr-module-card yang muncul di halaman katalog
           maupun halaman ruang, jadi didefinisikan sekali di sini. */
        .vr-status {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-family: var(--font-mono);
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.4em 0.75em;
            border-radius: var(--radius-pill);
            border: 1px solid transparent;
        }

        .vr-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .vr-status-tersedia {
            background: rgba(16, 132, 91, 0.12);
            border-color: rgba(16, 132, 91, 0.28);
            color: #10845b;
        }

        .vr-status-pengembangan {
            background: rgba(180, 105, 8, 0.12);
            border-color: rgba(180, 105, 8, 0.28);
            color: #b46908;
        }

        .vr-status-rencana {
            background: rgba(70, 83, 107, 0.12);
            border-color: rgba(70, 83, 107, 0.26);
            color: var(--muted);
        }

        .vr-module-room {
            display: inline-flex;
            align-items: center;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--secondary-color);
        }

        .vr-module-room:hover {
            color: var(--primary-color);
        }

        /* ===== Segmen unggulan VR di landing ===== */
        .vr-highlight-visual {
            position: relative;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.85rem;
        }

        .vr-highlight-room {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            padding: 1rem;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            transition: transform 0.25s ease, background 0.25s ease;
        }

        .vr-highlight-room:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.14);
        }

        .vr-highlight-room i {
            font-size: 1.15rem;
            color: #a5f3fc;
        }

        .vr-highlight-room span {
            font-size: 0.82rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.92);
            line-height: 1.35;
        }

        @media (prefers-reduced-motion: reduce) {
            .vr-highlight-room:hover {
                transform: none;
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
            background: linear-gradient(140deg, var(--primary-bright), var(--secondary-bright));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            box-shadow: 0 12px 28px rgba(14, 116, 144, 0.40);
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
                box-shadow: 0 12px 28px rgba(14, 116, 144, 0.40), 0 0 0 0 rgba(34, 211, 238, 0.55);
            }
            50% {
                box-shadow: 0 12px 28px rgba(14, 116, 144, 0.40), 0 0 0 14px rgba(34, 211, 238, 0);
            }
        }

        /* ===== Footer — dark glass ===== */
        footer {
            position: relative;
            background:
                radial-gradient(40rem 20rem at 12% 0%, rgba(47, 95, 224, 0.45), transparent 62%),
                radial-gradient(34rem 18rem at 88% 12%, rgba(14, 116, 144, 0.45), transparent 62%),
                #070c1a;
            color: rgba(255, 255, 255, 0.85);
            padding: 64px 0 28px;
            overflow: hidden;
        }

        /* Light beam along the top edge, mirroring the navbar scanline */
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--secondary-bright), var(--primary-bright), transparent);
            opacity: 0.7;
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
            background: linear-gradient(90deg, var(--secondary-bright), var(--primary-bright));
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .footer-links a:hover {
            color: #a5f3fc;
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
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: all 0.2s ease;
        }

        .social-links a:hover {
            background: linear-gradient(140deg, var(--primary-bright), var(--secondary-bright));
            border-color: transparent;
            transform: translateY(-3px);
        }

        footer hr {
            border-color: rgba(255, 255, 255, 0.12);
            margin: 30px 0 20px;
        }

        footer .text-center {
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.88rem;
        }

        /* ===== Latar section ======================================================
           Dulu berisi pola ikon ergonomi + grid sebagai gambar latar. Sekarang
           teksturnya datang dari kanvas plexus site-wide di belakang seluruh
           halaman, jadi section-nya cukup dibuat tembus pandang — itulah yang
           membuat kartu kaca punya sesuatu untuk di-blur. Class-nya sengaja
           dipertahankan karena dipakai di 18 tempat. */
        .bg-particles {
            background: transparent;
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
            z-index: 1;
        }

        .wave-divider-bottom svg {
            display: block;
            width: calc(100% + 1.3px);
            height: 30px;
        }

        @media (min-width: 992px) {
            .wave-divider-bottom svg {
                height: 45px;
            }
        }

        /* ===== Graceful degradation ================================================
           Firefox with backdrop-filter disabled, and older Safari/Android, render a
           translucent panel with no blur — which over the aurora turns into unreadable
           mush. Where the filter is unsupported, fall back to near-solid surfaces. */
        @supports not ((-webkit-backdrop-filter: blur(1px)) or (backdrop-filter: blur(1px))) {
            .navbar,
            .navbar.navbar-scrolled {
                background: rgba(247, 250, 255, 0.98);
            }

            .card-flat,
            .list-row,
            .btn-outline-brand,
            .dropdown-menu,
            .product-card,
            .glass-panel {
                background: rgba(255, 255, 255, 0.96);
            }
        }

        /* ===== Motion preferences ==================================================
           Everything decorative stops; nothing that conveys information is animated. */
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .hero3d-tile,
            .hero3d-tile.tile-main .hero3d-gear-ring,
            .logo-track,
            .product-track,
            .floating-contact {
                animation: none;
            }

            .btn-brand::after {
                transition: none;
            }

            .card-flat:hover,
            .btn-brand:hover,
            .btn-outline-brand:hover,
            .list-row:hover,
            .product-card:hover,
            .partner-avatar:hover {
                transform: none;
            }

            /* Tanpa gerakan, marquee berubah jadi grid biasa — salinan kedua
               (yang hanya ada demi kemulusan putaran) disembunyikan. */
            .product-marquee {
                -webkit-mask-image: none;
                mask-image: none;
                padding-inline: 1rem;
            }

            .product-track {
                flex-wrap: wrap;
                justify-content: center;
                width: 100%;
            }

            .product-card[data-clone="true"] {
                display: none;
            }
        }
    </style>

    {{-- Style khusus per halaman. Tanpa stack ini, setiap @push('styles') di view
         akan dibuang diam-diam — itulah sebabnya style tab di halaman Asisten,
         Kolaborator, dan detail Prestasi sebelumnya tidak pernah tampil.
         Diletakkan setelah <style> di atas supaya halaman bisa menimpa token. --}}
    @stack('styles')
</head>
<body>
    {{-- Latar plexus: jaring titik-garis animasi di belakang seluruh halaman --}}
    <canvas class="plexus-bg" aria-hidden="true"></canvas>

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
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}#home">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('asisten-laboratorium*', 'kepala-laboratorium*', 'dosen-laboratorium*') ? 'active' : ''}}" href="#" id="asistenDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tim Laboratorium
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="asistenDropdown">
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
                        <a class="nav-link {{ request()->routeIs('vr-ergonomy.*') ? 'active' : '' }}" href="{{ route('vr-ergonomy.index') }}">VR Ergonomy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('proyek-laboratorium.index') ? 'active' : '' }}" href="{{ route('proyek-laboratorium.index') }}">Proyek Laboratorium</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('public.alumni.index') ? 'active' : '' }}" href="{{ route('public.alumni.index') }}">Alumni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('program-pkl') ? 'active' : '' }}" href="{{ route('program-pkl') }}">Program PKL</a>
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
                        <a href="{{ route('home') }}#produk">Produk Unggulan</a>
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

    {{-- ===== Latar plexus =====================================================
         Jaring titik yang saling terhubung ketika berdekatan. Ditulis langsung
         dengan Canvas 2D, tanpa pustaka pihak ketiga: keseluruhannya di bawah
         100 baris, sementara paket plexus siap pakai umumnya jauh lebih berat
         dan sudah lama tidak dirawat.

         Tiga hal yang menjaga agar ini tidak membebani perangkat pengunjung:
         jumlah titik dihitung dari luas layar (dan dibatasi), animasi berhenti
         saat tab tidak aktif, dan pengguna dengan preferensi hemat gerak hanya
         mendapat satu frame diam. --}}
    <script>
        (function () {
            var canvas = document.querySelector('.plexus-bg');
            if (!canvas || !canvas.getContext) {
                return;
            }

            var ctx = canvas.getContext('2d');
            var hematGerak = window.matchMedia('(prefers-reduced-motion: reduce)');

            var JARAK_SAMBUNG = 175;   // px — di atas ini dua titik tidak dihubungkan
            var KERAPATAN = 10000;     // 1 titik per sekian px² viewport
            var MAKS_TITIK = 160;      // batas atas: biaya gambar tumbuh kuadratik

            var lebar = 0, tinggi = 0, titik = [], frame = null;

            function acak(min, maks) {
                return min + Math.random() * (maks - min);
            }

            function taburTitik() {
                var jumlah = Math.min(MAKS_TITIK, Math.round((lebar * tinggi) / KERAPATAN));
                titik = [];
                for (var i = 0; i < jumlah; i++) {
                    titik.push({
                        x: Math.random() * lebar,
                        y: Math.random() * tinggi,
                        dx: acak(-0.22, 0.22),
                        dy: acak(-0.22, 0.22),
                        r: acak(1.4, 2.9),
                    });
                }
            }

            function ukurUlang() {
                // Dibatasi 2 supaya layar dengan DPR 3 tidak menggambar 9x piksel.
                var dpr = Math.min(window.devicePixelRatio || 1, 2);
                lebar = canvas.clientWidth;
                tinggi = canvas.clientHeight;
                canvas.width = Math.round(lebar * dpr);
                canvas.height = Math.round(tinggi * dpr);
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                taburTitik();
            }

            function gambar() {
                ctx.clearRect(0, 0, lebar, tinggi);

                // Garis dulu, titik belakangan, supaya simpul tampak di atas jaring.
                ctx.lineWidth = 1.2;
                for (var i = 0; i < titik.length; i++) {
                    var a = titik[i];
                    for (var j = i + 1; j < titik.length; j++) {
                        var b = titik[j];
                        var dx = a.x - b.x;
                        var dy = a.y - b.y;
                        var jarakKuadrat = dx * dx + dy * dy;
                        if (jarakKuadrat > JARAK_SAMBUNG * JARAK_SAMBUNG) {
                            continue;
                        }
                        // Makin dekat, makin pekat — sqrt hanya dihitung untuk
                        // pasangan yang lolos ambang di atas.
                        var kepekatan = (1 - Math.sqrt(jarakKuadrat) / JARAK_SAMBUNG) * 0.62;
                        ctx.strokeStyle = 'rgba(47, 95, 224, ' + kepekatan.toFixed(3) + ')';
                        ctx.beginPath();
                        ctx.moveTo(a.x, a.y);
                        ctx.lineTo(b.x, b.y);
                        ctx.stroke();
                    }
                }

                ctx.fillStyle = 'rgba(14, 116, 144, 0.80)';
                for (var k = 0; k < titik.length; k++) {
                    var t = titik[k];
                    ctx.beginPath();
                    ctx.arc(t.x, t.y, t.r, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            function langkah() {
                for (var i = 0; i < titik.length; i++) {
                    var t = titik[i];
                    t.x += t.dx;
                    t.y += t.dy;
                    // Pantulkan di tepi, bukan dibungkus, agar tidak ada titik
                    // yang tiba-tiba muncul di seberang layar.
                    if (t.x <= 0 || t.x >= lebar) { t.dx *= -1; }
                    if (t.y <= 0 || t.y >= tinggi) { t.dy *= -1; }
                }
                gambar();
                frame = window.requestAnimationFrame(langkah);
            }

            function jalan() {
                if (frame === null) {
                    frame = window.requestAnimationFrame(langkah);
                }
            }

            function berhenti() {
                if (frame !== null) {
                    window.cancelAnimationFrame(frame);
                    frame = null;
                }
            }

            ukurUlang();

            if (hematGerak.matches) {
                gambar();   // satu frame diam, tanpa animasi
            } else {
                jalan();
            }

            var tundaUkur = null;
            window.addEventListener('resize', function () {
                window.clearTimeout(tundaUkur);
                tundaUkur = window.setTimeout(function () {
                    ukurUlang();
                    if (hematGerak.matches) {
                        gambar();
                    }
                }, 200);
            }, { passive: true });

            // Jangan bakar baterai untuk tab yang tidak dilihat siapa pun.
            document.addEventListener('visibilitychange', function () {
                if (document.hidden || hematGerak.matches) {
                    berhenti();
                } else {
                    jalan();
                }
            });
        })();
    </script>

    @stack('scripts')
    @stack('modals')
</body>
</html>