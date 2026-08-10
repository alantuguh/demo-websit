@extends('layout.app')

@section('title', $prestasiKegiatan->judul)

@push('styles')
<style>
    .content-img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
</style>
@endpush

@section('content')

    {{-- ===================== HERO ===================== --}}
    <section class="page-hero" style="padding: 90px 0 70px;">
        <div class="container position-relative text-center" style="z-index: 1;">
            <span class="eyebrow" data-aos="fade-up">
                <i class="fas {{ $prestasiKegiatan->jenis === 'prestasi' ? 'fa-trophy' : 'fa-bolt' }} me-1"></i>
                {{ ucfirst($prestasiKegiatan->jenis) }}
            </span>
            <h1 class="fw-bold mb-3" style="letter-spacing: -1px; font-size: 2.2rem;" data-aos="fade-up" data-aos-delay="100">
                {{ $prestasiKegiatan->judul }}
            </h1>
            <p class="mx-auto mb-0" style="max-width: 620px;" data-aos="fade-up" data-aos-delay="200">
                <i class="far fa-calendar-alt me-1"></i> {{ $prestasiKegiatan->tanggal->format('d F Y') }}
            </p>
        </div>

        <!-- Decorative elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0; opacity: 0.12;">
            <div class="position-absolute" style="top: 15%; left: 8%; width: 100px; height: 100px; background: #fff; border-radius: 50%;"></div>
            <div class="position-absolute" style="top: 55%; right: 12%; width: 60px; height: 60px; background: #fff; border-radius: 50%;"></div>
            <div class="position-absolute" style="bottom: 15%; left: 25%; width: 80px; height: 80px; background: #fff; border-radius: 50%;"></div>
        </div>
    </section>

    {{-- ===================== CONTENT ===================== --}}
    <section class="py-5 bg-particles" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="card-flat p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="badge rounded-pill text-uppercase px-3 py-2" style="font-size: 0.75em; background: {{ $prestasiKegiatan->jenis === 'prestasi' ? 'var(--secondary-color)' : 'var(--primary-color)' }}; color: #fff;">
                                <i class="fas {{ $prestasiKegiatan->jenis === 'prestasi' ? 'fa-trophy' : 'fa-bolt' }} me-1"></i>
                                {{ ucfirst($prestasiKegiatan->jenis) }}
                            </span>
                            @if($prestasiKegiatan->is_featured)
                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-star me-1"></i> Tampil di Beranda
                                </span>
                            @endif
                        </div>

                        @if($prestasiKegiatan->is_video)
                            <div class="ratio ratio-16x9 mb-4">
                                <iframe
                                    src="{{ $prestasiKegiatan->video_url }}"
                                    title="{{ $prestasiKegiatan->judul }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @elseif($prestasiKegiatan->gambar)
                            <img src="{{ $prestasiKegiatan->gambar_url }}" alt="{{ $prestasiKegiatan->judul }}" class="img-fluid img-thumb-accent rounded-3 mb-4">
                        @endif

                        <div class="content fs-5" style="color: var(--muted);">
                            {!! $prestasiKegiatan->deskripsi !!}
                        </div>

                        <div class="mt-4 pt-4" style="border-top: 1px solid var(--hairline);">
                            <a href="{{ route('prestasi-kegiatan.index') }}" class="btn btn-outline-brand">
                                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@if($relatedItems->count() > 0)
    {{-- ===================== RELATED ITEMS ===================== --}}
    <section class="py-5 bg-particles" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow">Kabar Terbaru</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">
                    {{ $prestasiKegiatan->jenis === 'prestasi' ? 'Prestasi Lainnya' : 'Kegiatan Lainnya' }}
                </h2>
            </div>
            <div class="row g-4">
                @foreach($relatedItems as $item)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
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
                        @else
                            <img src="{{ $item->gambar_url }}" class="w-100 img-thumb-accent" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="p-4">
                            <h5 class="fw-bold mb-2">{{ $item->judul }}</h5>
                            <p class="text-muted mb-3">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2" style="border-top: 1px solid var(--hairline);">
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>{{ $item->tanggal->format('d M Y') }}</small>
                                <a href="{{ route('prestasi-kegiatan.show', $item) }}" class="btn btn-sm btn-outline-brand px-3">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection