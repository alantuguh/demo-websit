@extends('layout.app')

@section('title', 'Proyek Laboratorium')

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
            <h1 class="fw-bold">Proyek Laboratorium</h1>
            <p class="lead text-muted">Program dan proyek kerja sama Laboratorium LPSKE, meliputi Wibawa, Jarpak, Semesta, DIKTI, dan Kerja Sama UNS</p>
        </div>
    </div>
</section>

<!-- Filter Kategori -->
<section class="py-4">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center filter-pills">
            <a href="{{ route('proyek-laboratorium.index') }}"
               class="btn {{ $kategoriAktif ? 'btn-outline-primary' : 'btn-primary' }}">
                Semua
            </a>
            @foreach($kategoriOptions as $value => $label)
                <a href="{{ route('proyek-laboratorium.index', ['kategori' => $value]) }}"
                   class="btn {{ $kategoriAktif === $value ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Proyek Section -->
<section class="pb-5">
    <div class="container">
        @if($proyek->count() > 0)
            <div class="row g-4">
                @foreach($proyek as $item)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->judul_proyek }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">
                                    {{ $kategoriOptions[$item->kategori] ?? ucfirst($item->kategori) }}
                                </span>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $item->tahun }}
                                </small>
                            </div>
                            <h5 class="card-title">{{ $item->judul_proyek }}</h5>
                            @if($item->mitra)
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-handshake me-1"></i> {{ $item->mitra }}
                                </p>
                            @endif
                            <p class="card-text text-muted">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                            <span class="badge {{ $item->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $statusOptions[$item->status] ?? ucfirst($item->status) }}
                            </span>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('proyek-laboratorium.show', $item) }}" class="btn btn-outline-primary">Lihat Detail</a>
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
