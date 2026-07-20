@extends('layout.app')

@section('title', 'Prestasi & Kegiatan')

@push('styles')
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    .badge-prestasi {
        background-color: #198754;
    }
    .badge-kegiatan {
        background-color: #0dcaf0;
    }
    .content-img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center">
            <h1 class="fw-bold">Prestasi & Kegiatan</h1>
        </div>
    </div>
</section>

<!-- Prestasi Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Prestasi</h2>
            <p class="lead text-muted">Daftar prestasi yang telah diraih oleh Laboratorium Perancangan Sistem Kerja dan Ergonomi</p>
        </div>
        
        @if($prestasi->count() > 0)
            <div class="row g-4">
                @foreach($prestasi as $item)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
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
                            <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->judul }}">
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="fas fa-image fa-5x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge {{ $item->jenis === 'prestasi' ? 'bg-success' : 'bg-info' }}">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $item->tanggal->format('d M Y') }}
                                </small>
                            </div>
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('prestasi-kegiatan.show', $item) }}" class="btn btn-outline-primary">Lihat Detail</a>
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

<!-- Kegiatan Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-center">Kegiatan</h2>
            <p class="lead text-muted">Berbagai kegiatan yang telah dilaksanakan oleh Laboratorium Perancangan Sistem Kerja dan Ergonomi</p>
        </div>
        
        @if($kegiatan->count() > 0)
            <div class="row g-4">
                @foreach($kegiatan as $item)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
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
                            <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->judul }}">
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="fas fa-image fa-5x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge {{ $item->jenis === 'prestasi' ? 'bg-success' : 'bg-info' }}">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $item->tanggal->format('d M Y') }}
                                </small>
                            </div>
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('prestasi-kegiatan.show', $item) }}" class="btn btn-outline-primary">Lihat Detail</a>
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
