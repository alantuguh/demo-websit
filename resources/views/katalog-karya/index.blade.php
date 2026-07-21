@extends('layout.app')

@section('title', 'Katalog Produk & Karya')

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
    .filter-pills .btn {
        border-radius: 50px;
        margin: 0 0.25rem 0.5rem 0.25rem;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center">
            <h1 class="fw-bold">Katalog Produk & Karya</h1>
            <p class="lead text-muted">Hasil penelitian, produk inovasi, publikasi, dan prototipe yang dihasilkan oleh Laboratorium LPSKE</p>
        </div>
    </div>
</section>

<!-- Filter Kategori -->
<section class="py-4">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center filter-pills">
            <a href="{{ route('katalog-karya.index') }}"
               class="btn {{ $kategoriAktif ? 'btn-outline-primary' : 'btn-primary' }}">
                Semua
            </a>
            @foreach($kategoriOptions as $value => $label)
                <a href="{{ route('katalog-karya.index', ['kategori' => $value]) }}"
                   class="btn {{ $kategoriAktif === $value ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Katalog Section -->
<section class="pb-5">
    <div class="container">
        @if($karya->count() > 0)
            <div class="row g-4">
                @foreach($karya as $item)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ $item->file_gambar_url }}" class="card-img-top" alt="{{ $item->nama_karya }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">
                                    {{ $kategoriOptions[$item->kategori] ?? ucfirst($item->kategori) }}
                                </span>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $item->tahun }}
                                </small>
                            </div>
                            <h5 class="card-title">{{ $item->nama_karya }}</h5>
                            @if($item->tim_penulis)
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-users me-1"></i> {{ $item->tim_penulis }}
                                </p>
                            @endif
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('katalog-karya.show', $item) }}" class="btn btn-outline-primary">Lihat Detail</a>
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
