@extends('layout.app')

@section('title', 'Katalog Produk & Karya')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="position-relative overflow-hidden" style="background: linear-gradient(360deg, rgba(195, 208, 227, 0.75) 0%,  rgba(174, 191, 218, 0.75) 100%), url('{{ asset('images/lab.jpg') }}'); padding: 110px 0 90px; background-size: cover; background-position: center;">
    <div class="container">
        <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="eyebrow" data-aos="fade-up"><i class="fas fa-lightbulb me-1"></i> Hasil Karya Kami</span>
                <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
                    Katalog Produk & <span class="text-gradient">Karya</span>
                </h1>
                <p class="lead mx-auto mx-lg-0" style="max-width: 560px; color: var(--ink);" data-aos="fade-up" data-aos-delay="200">
                    Hasil penelitian, produk inovasi, publikasi, dan prototipe yang dihasilkan oleh Laboratorium LPSKE.
                </p>
            </div>
            <div class="col-lg-5 mx-auto text-center">
                <div class="hero3d-stage" data-aos="fade-left" data-aos-delay="150">
                    <span class="hero3d-orb o1"></span>
                    <span class="hero3d-orb o2"></span>
                    <div class="hero3d-tile tile-main g-secondary" title="Inovasi"><i class="fas fa-lightbulb"></i></div>
                    <div class="hero3d-tile tile-1 g-primary" title="Produk"><i class="fas fa-box-open"></i></div>
                    <div class="hero3d-tile tile-2 g-accent" title="Publikasi"><i class="fas fa-file-lines"></i></div>
                    <div class="hero3d-tile tile-3 g-light" title="Prototipe"><i class="fas fa-gear"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== FILTER ===================== --}}
<section class="py-4 bg-particles">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-2" data-aos="fade-up">
            <a href="{{ route('katalog-karya.index') }}"
               class="btn {{ $kategoriAktif ? 'btn-outline-brand' : 'btn-brand' }} btn-sm px-3">
                Semua
            </a>
            @foreach($kategoriOptions as $value => $label)
                <a href="{{ route('katalog-karya.index', ['kategori' => $value]) }}"
                   class="btn {{ $kategoriAktif === $value ? 'btn-brand' : 'btn-outline-brand' }} btn-sm px-3">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== KATALOG GRID ===================== --}}
<section class="pb-5 bg-particles" style="padding-bottom: 6rem !important;">
    <div class="container">
        @if($karya->count() > 0)
            <div class="row g-4">
                @foreach($karya as $item)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                    <div class="card-flat h-100 overflow-hidden">
                        <img src="{{ $item->file_gambar_url }}" class="w-100 img-thumb-accent" alt="{{ $item->nama_karya }}" style="height: 200px; object-fit: cover;">
                        <div class="p-4 d-flex flex-column h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge rounded-pill px-3 py-2" style="background: var(--primary-color); color: #fff;">
                                    {{ $kategoriOptions[$item->kategori] ?? ucfirst($item->kategori) }}
                                </span>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $item->tahun }}
                                </small>
                            </div>
                            <h5 class="fw-bold mb-2">{{ $item->nama_karya }}</h5>
                            @if($item->tim_penulis)
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-users me-1"></i> {{ $item->tim_penulis }}
                                </p>
                            @endif
                            <p class="text-muted mb-3">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                            <div class="mt-auto pt-2" style="border-top: 1px solid rgba(17,24,39,0.06);">
                                <a href="{{ route('katalog-karya.show', $item) }}" class="btn btn-outline-brand w-100 mt-3">
                                    <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $karya->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="alert alert-info">Belum ada karya yang tersedia untuk kategori ini</div>
            </div>
        @endif
    </div>
</section>
@endsection
