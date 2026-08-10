@extends('layout.app')

@section('content')

    {{-- ===================== HERO RUANG ===================== --}}
    <section class="page-hero" style="padding: 100px 0 60px;">
        <div class="container">
            <div class="text-center mx-auto" style="max-width: 780px;">
                <a href="{{ route('vr-ergonomy.index') }}" class="vr-back mb-3" data-aos="fade-up">
                    <i class="fas fa-arrow-left me-2" aria-hidden="true"></i> VR Ergonomy Lab
                </a>

                <span class="eyebrow d-block" data-aos="fade-up" data-aos-delay="50">
                    <i class="fas {{ $room->ikon }} me-1"></i> {{ $room->tema ?? 'Ruang Tematik' }}
                </span>

                <h1 class="display-6 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
                    {{ $room->nama }}
                </h1>

                @if ($room->deskripsi)
                    <p class="lead mb-0 mx-auto" style="max-width: 680px;" data-aos="fade-up" data-aos-delay="200">
                        {{ $room->deskripsi }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    {{-- ===================== CAPAIAN + MODUL ===================== --}}
    <section class="py-5 bg-particles" style="padding-top: 5rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="row g-5">

                {{-- Capaian pembelajaran --}}
                <div class="col-lg-4" data-aos="fade-up">
                    <span class="eyebrow"><i class="fas fa-bullseye me-1"></i> Capaian</span>
                    <h2 class="section-title mb-3" style="font-size: 1.5rem;">Capaian Pembelajaran</h2>

                    @if (!empty($room->capaian))
                        @foreach ($room->capaian as $capaian)
                            <div class="list-row list-row-accent">
                                <i class="fas fa-check me-2" style="color: var(--secondary-color);" aria-hidden="true"></i>
                                <span style="font-size: 0.9rem;">{{ $capaian }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted" style="font-size: 0.92rem;">Capaian pembelajaran ruang ini belum ditetapkan.</p>
                    @endif
                </div>

                {{-- Daftar modul di ruang ini --}}
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                    <span class="eyebrow"><i class="fas fa-cubes me-1"></i> Modul</span>
                    <h2 class="section-title mb-3" style="font-size: 1.5rem;">
                        {{ $modules->count() }} Modul di Ruang Ini
                    </h2>

                    @if ($modules->isEmpty())
                        <div class="card-flat p-5 text-center">
                            <p class="text-muted mb-0">Modul untuk ruang ini sedang disiapkan.</p>
                        </div>
                    @else
                        <div class="row g-4">
                            @foreach ($modules as $modul)
                                <div class="col-md-6">
                                    @include('partials.vr-module-card', ['modul' => $modul, 'tampilkanRuang' => false])
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== RUANG LAIN ===================== --}}
    @if ($roomLain->isNotEmpty())
        <section class="py-5 bg-particles" style="padding-top: 2rem !important; padding-bottom: 6rem !important;">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="eyebrow"><i class="fas fa-door-open me-1"></i> Lanjutkan</span>
                    <h2 class="section-title text-center" style="font-size: 1.7rem;">Ruang Lainnya</h2>
                </div>

                <div class="row g-4">
                    @foreach ($roomLain as $i => $lain)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                            <a href="{{ route('vr-ergonomy.room', $lain) }}"
                               class="vr-room-card card-flat h-100 p-4 text-decoration-none d-block"
                               style="--room-warna: {{ $lain->warna }};">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="vr-room-icon"><i class="fas {{ $lain->ikon }}"></i></span>
                                </div>
                                <h5 class="fw-bold mb-1">{{ $lain->nama }}</h5>
                                @if ($lain->tema)
                                    <p class="vr-room-tema mb-2">{{ $lain->tema }}</p>
                                @endif
                                <span class="product-link">
                                    Masuk ruang <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('styles')
<style>
    /* Kartu ruang dipakai juga di halaman ini (bagian "Ruang Lainnya"),
       jadi gayanya diulang di sini agar halaman berdiri sendiri. */
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

    /* Tautan kembali di atas judul ruang, di dalam band hero yang gelap */
    .vr-back {
        display: inline-flex;
        align-items: center;
        font-size: 0.86rem;
        font-weight: 600;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.85);
        transition: color 0.2s ease;
    }

    .vr-back:hover {
        color: #a5f3fc;
    }
</style>
@endpush
