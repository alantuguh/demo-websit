@extends('layout.app')

@section('content')

    {{-- ===================== HERO ===================== --}}
    <section class="page-hero" id="vr-ergonomy">
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="eyebrow" data-aos="fade-up">
                        <i class="fas fa-vr-cardboard me-1"></i> Laboratorium Virtual
                    </span>
                    <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
                        VR <span class="text-gradient">Ergonomy</span> Lab
                    </h1>
                    <p class="lead mx-auto mx-lg-0" style="max-width: 620px;" data-aos="fade-up" data-aos-delay="200">
                        Replika laboratorium LPSKE dalam realitas virtual. Praktikum ergonomi dijalankan di
                        ruang-ruang tematik — mengukur, menilai postur, dan merancang stasiun kerja tanpa
                        dibatasi jumlah alat maupun jam operasional laboratorium fisik.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 mt-4"
                         data-aos="fade-up" data-aos-delay="300">
                        <a href="#denah" class="btn btn-brand btn-lg px-4">
                            <i class="fas fa-door-open me-2"></i> Jelajahi Ruang
                        </a>
                        <a href="#katalog" class="btn btn-outline-brand btn-lg px-4">
                            <i class="fas fa-cubes me-2"></i> Katalog Modul
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 mx-auto text-center">
                    <div class="hero3d-stage" data-aos="fade-left" data-aos-delay="150">
                        <span class="hero3d-orb o1"></span>
                        <span class="hero3d-orb o2"></span>
                        <div class="hero3d-tile tile-main g-primary" title="VR"><i class="fas fa-vr-cardboard"></i></div>
                        <div class="hero3d-tile tile-1 g-secondary" title="Antropometri"><i class="fas fa-ruler-combined"></i></div>
                        <div class="hero3d-tile tile-2 g-accent" title="Postur"><i class="fas fa-person-walking"></i></div>
                        <div class="hero3d-tile tile-3 g-light" title="Ruang"><i class="fas fa-cubes"></i></div>
                    </div>
                </div>

                <div class="wave-divider-bottom">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path d="M321.45,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C79.44,114.28,154.58,109.11,218.4,92.83c31.11-7.92,61.85-18.7,92.93-29.21Z" fill="rgba(239, 243, 252, 0.94)"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== KONSEP ===================== --}}
    <section class="py-5 bg-particles" id="konsep" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-lightbulb me-1"></i> Konsep</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Kenapa Laboratorium Virtual?</h2>
                <p class="section-subtitle mx-auto">
                    Praktikum ergonomi terbentur tiga hal: jumlah alat terbatas, jam laboratorium terbatas,
                    dan sebagian skenario kerja terlalu berisiko untuk diperagakan langsung. VR Ergonomy Lab
                    menjawab ketiganya.
                </p>
            </div>

            <div class="row g-4">
                @php
                    $pilar = [
                        [
                            'ikon' => 'fa-infinity',
                            'judul' => 'Tanpa Antre Alat',
                            'teks' => 'Satu set alat fisik dipakai bergantian oleh puluhan mahasiswa. Di VR, setiap orang memegang alatnya sendiri pada waktu yang sama.',
                        ],
                        [
                            'ikon' => 'fa-shield-halved',
                            'judul' => 'Aman untuk Skenario Berisiko',
                            'teks' => 'Postur kerja ekstrem, beban angkat berat, dan lingkungan bersuhu tinggi bisa disimulasikan tanpa memaparkan mahasiswa pada risiko cedera.',
                        ],
                        [
                            'ikon' => 'fa-chart-line',
                            'judul' => 'Terukur Otomatis',
                            'teks' => 'Setiap gerakan tercatat. Skor RULA/REBA, waktu siklus, dan jangkauan kerja dihitung sistem, bukan diamati manual oleh asisten.',
                        ],
                        [
                            'ikon' => 'fa-arrows-rotate',
                            'judul' => 'Bisa Diulang',
                            'teks' => 'Mahasiswa dapat mengulang skenario yang sama berkali-kali untuk membandingkan rancangan stasiun kerja sebelum dan sesudah perbaikan.',
                        ],
                    ];
                @endphp

                @foreach ($pilar as $i => $item)
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="card-flat h-100 p-4">
                            <span class="icon-circle mb-3"><i class="fas {{ $item['ikon'] }}"></i></span>
                            <h5 class="fw-bold mb-2">{{ $item['judul'] }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.92rem;">{{ $item['teks'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== DENAH RUANG ===================== --}}
    <section class="py-5 bg-particles" id="denah" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-door-open me-1"></i> Denah Lab</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">{{ $rooms->count() }} Ruang Tematik</h2>
                <p class="section-subtitle mx-auto">
                    Tiap ruang menampung modul latihan dengan tema yang sama, mengikuti alur praktikum
                    ergonomi di LPSKE. Klik satu ruang untuk melihat capaian pembelajaran dan modulnya.
                </p>
            </div>

            @if ($rooms->isEmpty())
                <div class="card-flat p-5 text-center">
                    <p class="text-muted mb-0">Ruang belum tersedia.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($rooms as $i => $room)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                            <a href="{{ route('vr-ergonomy.room', $room) }}"
                               class="vr-room-card card-flat h-100 p-4 text-decoration-none d-block"
                               style="--room-warna: {{ $room->warna }};">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="vr-room-icon"><i class="fas {{ $room->ikon }}"></i></span>
                                    <span class="badge-soft">{{ $room->modules_count }} modul</span>
                                </div>

                                <h5 class="fw-bold mb-1">{{ $room->nama }}</h5>

                                @if ($room->tema)
                                    <p class="vr-room-tema mb-2">{{ $room->tema }}</p>
                                @endif

                                @if ($room->deskripsi)
                                    <p class="text-muted mb-3" style="font-size: 0.9rem;">
                                        {{ Str::limit($room->deskripsi, 130) }}
                                    </p>
                                @endif

                                <span class="product-link">
                                    Masuk ruang <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ===================== KATALOG MODUL ===================== --}}
    <section class="py-5 bg-particles" id="katalog" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-4" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-cubes me-1"></i> Katalog</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Katalog Modul VR</h2>
                <p class="section-subtitle mx-auto">
                    {{ $totalModul }} modul terdaftar, {{ $totalTersedia }} di antaranya sudah dapat dijalankan.
                    Modul berstatus <em>Rencana</em> dan <em>Dalam Pengembangan</em> sengaja ditampilkan agar
                    peta pengembangan lab terlihat utuh.
                </p>
            </div>

            {{-- Filter per ruang. Sengaja memakai tautan biasa, bukan JavaScript,
                 supaya hasil filter bisa ditandai (bookmark) dan dibagikan. --}}
            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up">
                <a href="{{ route('vr-ergonomy.index') }}#katalog"
                   class="vr-filter {{ $roomAktif ? '' : 'vr-filter-active' }}">Semua Ruang</a>
                @foreach ($rooms as $room)
                    <a href="{{ route('vr-ergonomy.index', ['ruang' => $room->slug]) }}#katalog"
                       class="vr-filter {{ $roomAktif && $roomAktif->id === $room->id ? 'vr-filter-active' : '' }}">
                        {{ $room->nama }}
                    </a>
                @endforeach
            </div>

            @if ($modules->isEmpty())
                <div class="card-flat p-5 text-center">
                    <p class="text-muted mb-0">Belum ada modul pada ruang ini.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($modules as $i => $modul)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                            @include('partials.vr-module-card', ['modul' => $modul, 'tampilkanRuang' => true])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ===================== AJAKAN ===================== --}}
    <section class="py-5 position-relative band-deep section-py">
        <div class="container position-relative text-center" style="z-index: 1;">
            <span class="eyebrow">Kolaborasi</span>
            <h3 class="fw-bold mb-3" style="font-size: 2rem;">Ingin Modul VR untuk Topik Anda?</h3>
            <p class="lead mb-4 mx-auto" style="max-width: 640px;">
                Katalog ini terus bertambah. LPSKE terbuka untuk pengembangan modul bersama dosen,
                mitra industri, maupun laboratorium lain.
            </p>
            <a href="{{ route('home') }}#contact" class="btn btn-brand btn-lg px-4">
                <i class="fas fa-envelope me-2"></i> Hubungi LPSKE
            </a>
        </div>
    </section>

@endsection

@push('styles')
<style>
    /* ===== Kartu ruang =====================================================
       Warna aksen tiap ruang datang dari database lewat custom property
       --room-warna yang dipasang inline pada elemen kartu. */
    .vr-room-card {
        border-top: 3px solid var(--room-warna, var(--primary-bright));
    }

    .vr-room-card .vr-room-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #fff;
        background: linear-gradient(140deg, var(--room-warna, var(--primary-bright)), color-mix(in srgb, var(--room-warna, #4f7df3) 55%, #0b1430));
        box-shadow: 0 10px 22px color-mix(in srgb, var(--room-warna, #4f7df3) 38%, transparent);
    }

    /* color-mix belum ada di sebagian browser lama — jatuh ke warna datar. */
    @supports not (color: color-mix(in srgb, red 50%, blue)) {
        .vr-room-card .vr-room-icon {
            background: var(--room-warna, var(--primary-bright));
        }
    }

    .vr-room-card .vr-room-tema {
        font-family: var(--font-mono);
        font-size: 0.72rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--room-warna, var(--primary-color));
        margin: 0;
    }

    .vr-room-card h5 {
        color: var(--ink);
    }

    /* ===== Pil filter ruang ===== */
    .vr-filter {
        display: inline-block;
        padding: 0.5rem 1.1rem;
        border-radius: var(--radius-pill);
        font-size: 0.86rem;
        font-weight: 600;
        text-decoration: none;
        color: var(--ink);
        background: var(--glass-bg);
        -webkit-backdrop-filter: blur(12px) saturate(160%);
        backdrop-filter: blur(12px) saturate(160%);
        border: 1px solid var(--glass-border);
        box-shadow: 0 0 0 1px var(--glass-edge);
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .vr-filter:hover {
        background: rgba(79, 125, 243, 0.14);
        color: var(--primary-color);
    }

    .vr-filter-active {
        background: linear-gradient(100deg, var(--primary-color), var(--primary-bright));
        border-color: transparent;
        color: #fff;
        box-shadow: 0 12px 26px rgba(47, 95, 224, 0.34);
    }

    .vr-filter-active:hover {
        color: #fff;
    }
</style>
@endpush
