@extends('layout.app')

@section('title', $karyaLab->nama_karya)

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
            <h1 class="fw-bold">{{ $karyaLab->nama_karya }}</h1>
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
                        {{ $kategoriOptions[$karyaLab->kategori] ?? ucfirst($karyaLab->kategori) }}
                    </span>
                    <span class="text-muted">
                        <i class="far fa-calendar-alt me-1"></i> {{ $karyaLab->tahun }}
                    </span>
                </div>

                <img src="{{ $karyaLab->file_gambar_url }}" alt="{{ $karyaLab->nama_karya }}" class="img-fluid rounded mb-4">

                @if($karyaLab->tim_penulis)
                    <p class="text-muted mb-3">
                        <i class="fas fa-users me-1"></i> <strong>Tim Penulis:</strong> {{ $karyaLab->tim_penulis }}
                    </p>
                @endif

                <div class="content">
                    {!! nl2br(e($karyaLab->deskripsi)) !!}
                </div>

                @if($karyaLab->link_publikasi)
                    <div class="mt-4">
                        <a href="{{ $karyaLab->link_publikasi }}" target="_blank" rel="noopener" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-1"></i> Lihat Publikasi
                        </a>
                    </div>
                @endif

                <div class="mt-5 pt-4 border-top">
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-secondary">
                            <i class="fas fa-tag me-1"></i> {{ $kategoriOptions[$karyaLab->kategori] ?? ucfirst($karyaLab->kategori) }}
                        </span>
                        @if($karyaLab->is_featured)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i> Karya Unggulan
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
        <h3 class="mb-4">Karya Lainnya di Kategori Ini</h3>
        <div class="row g-4">
            @foreach($relatedItems as $item)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm related-card">
                    <img src="{{ $item->file_gambar_url }}" class="card-img-top" alt="{{ $item->nama_karya }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nama_karya }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('katalog-karya.show', $item) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
