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
            <h1 class="fw-bold">{{ $prestasiKegiatan->judul }}</h1>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="badge {{ $prestasiKegiatan->jenis === 'prestasi' ? 'bg-success' : 'bg-info' }}">
                        {{ ucfirst($prestasiKegiatan->jenis) }}
                    </span>
                    <span class="text-muted">
                        <i class="far fa-calendar-alt me-1"></i> {{ $prestasiKegiatan->tanggal->format('d F Y') }}
                    </span>
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
                    <img src="{{ $prestasiKegiatan->gambar_url }}" alt="{{ $prestasiKegiatan->judul }}" class="img-fluid rounded mb-4">
                @endif
                
                <div class="content">
                    {!! $prestasiKegiatan->deskripsi !!}
                </div>
                
                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-secondary">
                            <i class="fas fa-tag me-1"></i> {{ ucfirst($prestasiKegiatan->jenis) }}
                        </span>
                        @if($prestasiKegiatan->is_featured)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i> Tampil di Beranda
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
        <h3 class="mb-4">{{ $prestasiKegiatan->jenis === 'prestasi' ? 'Prestasi Lainnya' : 'Kegiatan Lainnya' }}</h3>
        <div class="row g-4">
            @foreach($relatedItems as $item)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm related-card">
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
                        <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->judul }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('prestasi-kegiatan.show', $item) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
