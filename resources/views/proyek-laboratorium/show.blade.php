@extends('layout.app')

@section('title', $proyekLaboratorium->judul_proyek)

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="page-hero" style="padding: 100px 0 60px;">
    <div class="container text-center">
        <span class="eyebrow" data-aos="fade-up">
            <i class="fas fa-tag me-1"></i> {{ $kategoriOptions[$proyekLaboratorium->kategori] ?? ucfirst($proyekLaboratorium->kategori) }}
        </span>
        <h1 class="display-6 fw-bold mx-auto" style="max-width: 780px; letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
            {{ $proyekLaboratorium->judul_proyek }}
        </h1>
    </div>
</section>

{{-- ===================== CONTENT ===================== --}}
<section class="py-5 bg-particles" style="padding-top: 4rem !important; padding-bottom: 6rem !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="card-flat p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="badge rounded-pill px-3 py-2" style="background: var(--primary-color); color: #fff;">
                            {{ $kategoriOptions[$proyekLaboratorium->kategori] ?? ucfirst($proyekLaboratorium->kategori) }}
                        </span>
                        <span class="text-muted">
                            <i class="far fa-calendar-alt me-1"></i> {{ $proyekLaboratorium->tahun }}
                        </span>
                    </div>

                    <img src="{{ $proyekLaboratorium->gambar_url }}" alt="{{ $proyekLaboratorium->judul_proyek }}" class="img-fluid img-thumb-accent rounded mb-4 w-100" style="max-height: 420px; object-fit: cover;">

                    @if($proyekLaboratorium->mitra)
                        <p class="text-muted mb-3">
                            <i class="fas fa-handshake me-1"></i> <strong>Mitra/Instansi:</strong> {{ $proyekLaboratorium->mitra }}
                        </p>
                    @endif

                    <div class="fs-5" style="color: var(--muted);">
                        {!! nl2br(e($proyekLaboratorium->deskripsi)) !!}
                    </div>

                    @if($proyekLaboratorium->link_terkait)
                        <div class="mt-4">
                            <a href="{{ $proyekLaboratorium->link_terkait }}" target="_blank" rel="noopener" class="btn btn-brand">
                                <i class="fas fa-external-link-alt me-2"></i> Lihat Selengkapnya
                            </a>
                        </div>
                    @endif

                    <div class="mt-5 pt-4" style="border-top: 1px solid var(--hairline);">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--accent-color); color: var(--primary-dark);">
                                <i class="fas fa-tag me-1"></i> {{ $kategoriOptions[$proyekLaboratorium->kategori] ?? ucfirst($proyekLaboratorium->kategori) }}
                            </span>
                            <span class="badge rounded-pill px-3 py-2" style="background: {{ $proyekLaboratorium->status === 'selesai' ? '#1c8a4a' : 'var(--secondary-color)' }}; color: #fff;">
                                <i class="fas fa-circle-info me-1"></i> {{ $statusOptions[$proyekLaboratorium->status] ?? ucfirst($proyekLaboratorium->status) }}
                            </span>
                            @if($proyekLaboratorium->is_featured)
                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-star me-1"></i> Proyek Unggulan
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedItems->count() > 0)
{{-- ===================== RELATED ===================== --}}
<section class="py-5" style="padding-bottom: 6rem !important;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="eyebrow">Rekomendasi</span>
            <h3 class="section-title text-center" style="font-size: 1.9rem;">Proyek Lainnya di Kategori Ini</h3>
        </div>
        <div class="row g-4">
            @foreach($relatedItems as $item)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                <div class="card-flat h-100 overflow-hidden">
                    <img src="{{ $item->gambar_url }}" class="w-100 img-thumb-accent" alt="{{ $item->judul_proyek }}" style="height: 200px; object-fit: cover;">
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $item->judul_proyek }}</h5>
                        <p class="text-muted mb-3">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                        <a href="{{ route('proyek-laboratorium.show', $item) }}" class="btn btn-outline-brand btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
