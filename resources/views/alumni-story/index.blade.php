@extends('layout.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="section-title text-center">Alumni Stories</h1>
        <p class="lead text-muted">Kisah Inspiratif dan Perjalanan Karier Alumni Kami</p>
    </div>

    @forelse($alumni as $angkatan => $items)
        <div class="mb-5">
            <div class="d-flex align-items-center mb-4">
                <div class="flex-grow-1">
                    <h2 class="fw-bold mb-0">Angkatan {{ $angkatan }}</h2>
                    <p class="text-muted mb-0">{{ count($items) }} cerita inspiratif</p>
                </div>
                <div class="border-top border-primary border-2 flex-grow-1 ms-3"></div>
            </div>
            
            <div class="row g-4">
                @foreach($items as $alumni)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 hover-shadow transition-all">
                            <div class="position-relative" style="height: 200px; overflow: hidden;">
                                @if($alumni->foto)
                                    <img src="{{ asset('storage/' . $alumni->foto) }}" 
                                         class="card-img-top w-100 h-100" 
                                         alt="{{ $alumni->nama }}" 
                                         style="object-fit: cover; transition: transform 0.3s ease;"
                                         onmouseover="this.style.transform='scale(1.05)'"
                                         onmouseout="this.style.transform='scale(1)'">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-light w-100 h-100">
                                        <i class="fas fa-user-graduate fa-4x text-muted"></i>
                                    </div>
                                @endif
                                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                                    <h5 class="text-white mb-0">{{ $alumni->nama }}</h5>
                                    <span class="text-white-50">Angkatan {{ $alumni->angkatan }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($alumni->pekerjaan || $alumni->perusahaan)
                                    <p class="text-primary mb-2">
                                        <i class="fas fa-briefcase me-2"></i>
                                        @if($alumni->pekerjaan && $alumni->perusahaan)
                                            {{ $alumni->pekerjaan }} di {{ $alumni->perusahaan }}
                                        @elseif($alumni->pekerjaan)
                                            {{ $alumni->pekerjaan }}
                                        @else
                                            {{ $alumni->perusahaan }}
                                        @endif
                                    </p>
                                @endif
                                
                                @if($alumni->testimoni)
                                    <div class="testimonial-text mb-3">
                                        <i class="fas fa-quote-left text-muted me-2"></i>
                                        {{ \Illuminate\Support\Str::limit($alumni->testimoni, 180) }}
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#alumniModal{{ $alumni->id }}">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="alumniModal{{ $alumni->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Kisah {{ $alumni->nama }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            @if($alumni->foto)
                                                <img src="{{ asset('storage/' . $alumni->foto) }}" 
                                                     class="img-fluid rounded-circle mb-3" 
                                                     alt="{{ $alumni->nama }}"
                                                     style="width: 200px; height: 200px; object-fit: cover;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto mb-3" 
                                                     style="width: 200px; height: 200px;">
                                                    <i class="fas fa-user-graduate fa-4x text-muted"></i>
                                                </div>
                                            @endif
                                            <h4 class="mb-1">{{ $alumni->nama }}</h4>
                                            <p class="text-muted mb-2">Angkatan {{ $alumni->angkatan }}</p>
                                            @if($alumni->pekerjaan || $alumni->perusahaan)
                                                <p class="text-primary">
                                                    <i class="fas fa-briefcase me-2"></i>
                                                    @if($alumni->pekerjaan && $alumni->perusahaan)
                                                        {{ $alumni->pekerjaan }} di {{ $alumni->perusahaan }}
                                                    @elseif($alumni->pekerjaan)
                                                        {{ $alumni->pekerjaan }}
                                                    @else
                                                        {{ $alumni->perusahaan }}
                                                    @endif
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <h5 class="mb-3">Kisah Inspiratif</h5>
                                            <div class="testimonial-text">
                                                @if($alumni->deskripsi)
                                                {!! $alumni->deskripsi !!}

                                                @else
                                                    <p class="text-muted">Tidak ada deskripsi yang tersedia.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <div class="display-1 text-muted mb-3">
                <i class="fas fa-book-open"></i>
            </div>
            <h3>Belum Ada Cerita Alumni</h3>
            <p class="lead">Cerita inspiratif dari alumni akan segera hadir</p>

        </div>
    @endforelse
</div>

@push('styles')
<style>
    .testimonial-text {
        font-style: italic;
        color: #555;
        line-height: 1.7;
    }
    .card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection