@extends('layout.app')

@section('title', $proyekLaboratorium->judul_proyek)

@push('styles')
<style>
    .content-img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    .related-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center">
            <h1 class="fw-bold">{{ $proyekLaboratorium->judul_proyek }}</h1>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="badge bg-primary">
                        {{ $kategoriOptions[$proyekLaboratorium->kategori] ?? ucfirst($proyekLaboratorium->kategori) }}
                    </span>
                    <span class="text-muted">
                        <i class="far fa-calendar-alt me-1"></i> {{ $proyekLaboratorium->tahun }}
                    </span>
                </div>

                <img src="{{ $proyekLaboratorium->gambar_url }}" alt="{{ $proyekLaboratorium->judul_proyek }}" class="img-fluid rounded mb-4">

                @if($proyekLaboratorium->mitra)
                    <p class="text-muted mb-3">
                        <i class="fas fa-handshake me-1"></i> <strong>Mitra/Instansi:</strong> {{ $proyekLaboratorium->mitra }}
                    </p>
                @endif

                <div class="content">
                    {!! nl2br(e($proyekLaboratorium->deskripsi)) !!}
                </div>

                @if($proyekLaboratorium->link_terkait)
                    <div class="mt-4">
                        <a href="{{ $proyekLaboratorium->link_terkait }}" target="_blank" rel="noopener" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat Selengkapnya
                        </a>
                    </div>
                @endif

                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-secondary">
                            <i class="fas fa-tag me-1"></i> {{ $kategoriOptions[$proyekLaboratorium->kategori] ?? ucfirst($proyekLaboratorium->kategori) }}
                        </span>
                        <span class="badge {{ $proyekLaboratorium->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                            <i class="fas fa-circle-info me-1"></i> {{ $statusOptions[$proyekLaboratorium->status] ?? ucfirst($proyekLaboratorium->status) }}
                        </span>
                        @if($proyekLaboratorium->is_featured)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i> Proyek Unggulan
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedItems->count() > 0)
<!-- Related Items -->
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="mb-4">Proyek Lainnya di Kategori Ini</h3>
        <div class="row g-4">
            @foreach($relatedItems as $item)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm related-card">
                    <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->judul_proyek }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->judul_proyek }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('proyek-laboratorium.show', $item) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
