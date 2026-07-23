@extends('layout.app')

@section('title', 'Prestasi & Kegiatan')

@section('content')

    {{-- ===================== HERO ===================== --}}
    <section class="position-relative overflow-hidden" style="background: linear-gradient(360deg, rgba(195, 208, 227, 0.75) 0%,  rgba(174, 191, 218, 0.75) 100%), url('{{ asset('images/lab.jpg') }}'); padding: 110px 0 90px; background-size: cover; background-position: center;">
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="eyebrow" data-aos="fade-up"><i class="fas fa-bolt me-1"></i> Kabar Terbaru</span>
                    <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
                        <span class="text-gradient">Prestasi</span> &amp; Kegiatan
                    </h1>
                    <p class="lead mx-auto mx-lg-0" style="max-width: 560px; color: var(--ink);" data-aos="fade-up" data-aos-delay="200">
                        Rekam jejak pencapaian dan berbagai kegiatan yang telah dilaksanakan oleh Laboratorium Perancangan Sistem Kerja dan Ergonomi.
                    </p>
                </div>
                <div class="col-lg-5 mx-auto text-center">
                    <div class="hero3d-stage" data-aos="fade-left" data-aos-delay="150">
                        <span class="hero3d-orb o1"></span>
                        <span class="hero3d-orb o2"></span>
                        <div class="hero3d-tile tile-main g-secondary" title="Prestasi"><i class="fas fa-trophy"></i></div>
                        <div class="hero3d-tile tile-1 g-primary" title="Penghargaan"><i class="fas fa-medal"></i></div>
                        <div class="hero3d-tile tile-2 g-accent" title="Kabar Terbaru"><i class="fas fa-bolt"></i></div>
                        <div class="hero3d-tile tile-3 g-light" title="Kegiatan"><i class="fas fa-calendar-check"></i></div>
                    </div>
                </div>
                <div class="wave-divider-bottom">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path d="M321.45,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C79.44,114.28,154.58,109.11,218.4,92.83c31.11-7.92,61.85-18.7,92.93-29.21Z" fill="rgba(112, 133, 177, 0.7)"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== PRESTASI ===================== --}}
    <section class="py-5 bg-particles" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-trophy me-1"></i> Pencapaian Kami</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Prestasi</h2>
                <p class="section-subtitle mx-auto">Daftar prestasi yang telah diraih oleh Laboratorium Perancangan Sistem Kerja dan Ergonomi.</p>
            </div>

            @if($prestasi->count() > 0)
                <div class="row g-4">
                    @foreach($prestasi as $item)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                        <div class="card-flat h-100 overflow-hidden">
                            @if($item->is_video)
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="{{ $item->video_url }}"
                                        title="{{ $item->judul }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @elseif($item->gambar)
                                <img src="{{ $item->gambar_url }}" class="w-100 img-thumb-accent" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light text-center py-5">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge rounded-pill text-uppercase px-3 py-2" style="font-size: 0.75em; background: var(--secondary-color); color: #fff;">
                                        <i class="fas fa-trophy me-1"></i> Prestasi
                                    </span>
                                    @if($item->is_featured)
                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                            <i class="fas fa-star me-1"></i> Unggulan
                                        </span>
                                    @endif
                                </div>
                                <h5 class="fw-bold mb-2">{{ $item->judul }}</h5>
                                <p class="text-muted mb-3">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2" style="border-top: 1px solid rgba(17,24,39,0.06);">
                                    <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>{{ $item->tanggal->format('d M Y') }}</small>
                                    <a href="{{ route('prestasi-kegiatan.show', $item) }}" class="btn btn-sm btn-outline-brand px-3">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $prestasi->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="alert alert-info">Belum ada data prestasi yang tersedia</div>
                </div>
            @endif
        </div>
    </section>

    {{-- ===================== KEGIATAN ===================== --}}
    <section class="py-5 bg-particles" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-calendar-check me-1"></i> Aktivitas Kami</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Kegiatan</h2>
                <p class="section-subtitle mx-auto">Berbagai kegiatan yang telah dilaksanakan oleh Laboratorium Perancangan Sistem Kerja dan Ergonomi.</p>
            </div>

            @if($kegiatan->count() > 0)
                <div class="row g-4">
                    @foreach($kegiatan as $item)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                        <div class="card-flat h-100 overflow-hidden">
                            @if($item->is_video)
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="{{ $item->video_url }}"
                                        title="{{ $item->judul }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @elseif($item->gambar)
                                <img src="{{ $item->gambar_url }}" class="w-100 img-thumb-accent" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-light text-center py-5">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge rounded-pill text-uppercase px-3 py-2" style="font-size: 0.75em; background: var(--primary-color); color: #fff;">
                                        <i class="fas fa-bolt me-1"></i> Kegiatan
                                    </span>
                                    @if($item->is_featured)
                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                            <i class="fas fa-star me-1"></i> Unggulan
                                        </span>
                                    @endif
                                </div>
                                <h5 class="fw-bold mb-2">{{ $item->judul }}</h5>
                                <p class="text-muted mb-3">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2" style="border-top: 1px solid rgba(17,24,39,0.06);">
                                    <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>{{ $item->tanggal->format('d M Y') }}</small>
                                    <a href="{{ route('prestasi-kegiatan.show', $item) }}" class="btn btn-sm btn-outline-brand px-3">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $kegiatan->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="alert alert-info">Belum ada data kegiatan yang tersedia</div>
                </div>
            @endif
        </div>
    </section>

@endsection