@extends('layout.app')

@section('title', $karyaLab->nama_karya)

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="position-relative overflow-hidden" style="background: linear-gradient(360deg, rgba(195, 208, 227, 0.5) 0%, #aebfda 100%); padding: 100px 0 60px;">
    <div class="container text-center">
        <span class="eyebrow" data-aos="fade-up">
            <i class="fas fa-tag me-1"></i> {{ $kategoriOptions[$karyaLab->kategori] ?? ucfirst($karyaLab->kategori) }}
        </span>
        <h1 class="display-6 fw-bold mx-auto" style="max-width: 780px; letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
            {{ $karyaLab->nama_karya }}
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
                            {{ $kategoriOptions[$karyaLab->kategori] ?? ucfirst($karyaLab->kategori) }}
                        </span>
                        <span class="text-muted">
                            <i class="far fa-calendar-alt me-1"></i> {{ $karyaLab->tahun }}
                        </span>
                    </div>

                    <img src="{{ $karyaLab->file_gambar_url }}" alt="{{ $karyaLab->nama_karya }}" class="img-fluid img-thumb-accent rounded mb-4 w-100" style="max-height: 420px; object-fit: cover;">

                    @if($karyaLab->tim_penulis)
                        <p class="text-muted mb-3">
                            <i class="fas fa-users me-1"></i> <strong>Tim Penulis:</strong> {{ $karyaLab->tim_penulis }}
                        </p>
                    @endif

                    <div class="fs-5" style="color: var(--muted);">
                        {!! nl2br(e($karyaLab->deskripsi)) !!}
                    </div>

                    @if($karyaLab->link_publikasi)
                        <div class="mt-4">
                            <a href="{{ $karyaLab->link_publikasi }}" target="_blank" rel="noopener" class="btn btn-brand">
                                <i class="fas fa-external-link-alt me-2"></i> Lihat Publikasi
                            </a>
                        </div>
                    @endif

                    <div class="mt-5 pt-4" style="border-top: 1px solid rgba(17,24,39,0.08);">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--accent-color); color: var(--primary-dark);">
                                <i class="fas fa-tag me-1"></i> {{ $kategoriOptions[$karyaLab->kategori] ?? ucfirst($karyaLab->kategori) }}
                            </span>
                            @if($karyaLab->is_featured)
                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-star me-1"></i> Karya Unggulan
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
            <h3 class="section-title text-center" style="font-size: 1.9rem;">Karya Lainnya di Kategori Ini</h3>
        </div>
        <div class="row g-4">
            @foreach($relatedItems as $item)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                <div class="card-flat h-100 overflow-hidden">
                    <img src="{{ $item->file_gambar_url }}" class="w-100 img-thumb-accent" alt="{{ $item->nama_karya }}" style="height: 200px; object-fit: cover;">
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $item->nama_karya }}</h5>
                        <p class="text-muted mb-3">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                        <a href="{{ route('katalog-karya.show', $item) }}" class="btn btn-outline-brand btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
