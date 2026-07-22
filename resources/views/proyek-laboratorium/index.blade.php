@extends('layout.app')

@section('title', 'Proyek Laboratorium')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="position-relative overflow-hidden" style="background: linear-gradient(360deg, rgba(195, 208, 227, 0.5) 0%, #aebfda 100%); padding: 110px 0 70px;">
    <div class="container text-center">
        <span class="eyebrow" data-aos="fade-up"><i class="fas fa-diagram-project me-1"></i> Kerja Sama & Pengabdian</span>
        <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
            Proyek <span class="text-gradient">Laboratorium</span>
        </h1>
        <p class="lead mx-auto" style="max-width: 660px; color: var(--ink);" data-aos="fade-up" data-aos-delay="200">
            Program dan proyek kerja sama Laboratorium LPSKE, meliputi Wibawa, Jarpak, Semesta, DIKTI, dan Kerja Sama UNS.
        </p>
    </div>
</section>

{{-- ===================== FILTER ===================== --}}
<section class="py-4 bg-particles">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-2" data-aos="fade-up">
            <a href="{{ route('proyek-laboratorium.index') }}"
               class="btn {{ $kategoriAktif ? 'btn-outline-brand' : 'btn-brand' }} btn-sm px-3">
                Semua
            </a>
            @foreach($kategoriOptions as $value => $label)
                <a href="{{ route('proyek-laboratorium.index', ['kategori' => $value]) }}"
                   class="btn {{ $kategoriAktif === $value ? 'btn-brand' : 'btn-outline-brand' }} btn-sm px-3">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== PROYEK GRID ===================== --}}
<section class="pb-5 bg-particles" style="padding-bottom: 6rem !important;">
    <div class="container">
        @if($proyek->count() > 0)
            <div class="row g-4">
                @foreach($proyek as $item)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                    <div class="card-flat h-100 overflow-hidden">
                        <img src="{{ $item->gambar_url }}" class="w-100 img-thumb-accent" alt="{{ $item->judul_proyek }}" style="height: 200px; object-fit: cover;">
                        <div class="p-4 d-flex flex-column h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge rounded-pill px-3 py-2" style="background: var(--primary-color); color: #fff;">
                                    {{ $kategoriOptions[$item->kategori] ?? ucfirst($item->kategori) }}
                                </span>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $item->tahun }}
                                </small>
                            </div>
                            <h5 class="fw-bold mb-2">{{ $item->judul_proyek }}</h5>
                            @if($item->mitra)
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-handshake me-1"></i> {{ $item->mitra }}
                                </p>
                            @endif
                            <p class="text-muted mb-3">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                            <span class="badge rounded-pill px-3 py-2 align-self-start mb-3" style="background: {{ $item->status === 'selesai' ? '#1c8a4a' : 'var(--secondary-color)' }}; color: #fff;">
                                {{ $statusOptions[$item->status] ?? ucfirst($item->status) }}
                            </span>
                            <div class="mt-auto pt-2" style="border-top: 1px solid rgba(17,24,39,0.06);">
                                <a href="{{ route('proyek-laboratorium.show', $item) }}" class="btn btn-outline-brand w-100 mt-3">
                                    <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $proyek->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="alert alert-info">Belum ada proyek yang tersedia untuk kategori ini</div>
            </div>
        @endif
    </div>
</section>
@endsection
