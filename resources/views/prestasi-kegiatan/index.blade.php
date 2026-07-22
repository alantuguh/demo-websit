@extends('layout.app')

@section('title', 'Prestasi & Kegiatan')

@section('content')

    {{-- ===================== HERO ===================== --}}
    <section class="position-relative overflow-hidden" style="background: linear-gradient(360deg, rgba(195, 208, 227, 0.5) 0%, #aebfda 100%); padding: 110px 0 90px;">
        <div class="container position-relative text-center" style="z-index: 1;">
            <span class="eyebrow" data-aos="fade-up"><i class="fas fa-bolt me-1"></i> Kabar Terbaru</span>
            <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
                <span class="text-gradient">Prestasi</span> &amp; Kegiatan
            </h1>
            <p class="lead mx-auto" style="max-width: 620px; color: var(--ink);" data-aos="fade-up" data-aos-delay="200">
                Rekam jejak pencapaian dan berbagai kegiatan yang telah dilaksanakan oleh Laboratorium Perancangan Sistem Kerja dan Ergonomi.
            </p>
        </div>

        <!-- Decorative elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0; opacity: 0.12;">
            <div class="position-absolute" style="top: 15%; left: 8%; width: 100px; height: 100px; background: #fff; border-radius: 50%;"></div>
            <div class="position-absolute" style="top: 55%; right: 12%; width: 60px; height: 60px; background: #fff; border-radius: 50%;"></div>
            <div class="position-absolute" style="bottom: 15%; left: 25%; width: 80px; height: 80px; background: #fff; border-radius: 50%;"></div>
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