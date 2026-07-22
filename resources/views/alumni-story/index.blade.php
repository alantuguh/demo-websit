@extends('layout.app')

@section('title', 'Alumni Stories')

@section('content')

    {{-- ===================== HERO / HEADER BAND ===================== --}}
    <section class="page-header-band position-relative overflow-hidden" style="background: linear-gradient(360deg, rgba(195, 208, 227, 0.5) 0%, #aebfda 100%); padding: 100px 0 60px;">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="eyebrow" data-aos="fade-up">
                        <i class="fas fa-graduation-cap me-1"></i> Jejak Alumni
                    </span>
                    <h1 class="display-5 fw-bold mb-3" data-aos="fade-up" data-aos-delay="100">
                        Alumni <span class="text-gradient">Stories</span>
                    </h1>
                    <p class="lead mb-0" style="color: var(--ink);" data-aos="fade-up" data-aos-delay="200">
                        Kisah inspiratif dan perjalanan karier alumni Laboratorium Perancangan Sistem Kerja dan Ergonomi (LPSKE).
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT & CARDS ===================== --}}
    <section class="bg-particles pt-5 pb-5">
        <div class="container">
            @forelse($alumni as $angkatan => $items)
                <div class="mb-5">
                    <div class="d-flex align-items-center mb-4" data-aos="fade-up">
                        <span class="icon-circle me-3">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        <div class="flex-grow-1">
                            <span class="eyebrow mb-1">Angkatan</span>
                            <h2 class="section-title mb-0" style="font-size: 1.8rem;">{{ $angkatan }}</h2>
                            <p class="text-muted mb-0 small">{{ count($items) }} cerita inspiratif</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach($items as $alumniItem)
                            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 90 }}">
                                <div class="card-flat h-100 overflow-hidden">
                                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                                        @if($alumniItem->foto)
                                            <img src="{{ asset('storage/' . $alumniItem->foto) }}"
                                                 class="w-100 h-100"
                                                 alt="{{ $alumniItem->nama }}"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center w-100 h-100" style="background: var(--surface);">
                                                <i class="fas fa-user-graduate fa-4x" style="color: var(--accent-color);"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(transparent, rgba(17,24,39,0.75));">
                                            <h5 class="text-white mb-0">{{ $alumniItem->nama }}</h5>
                                            <span class="text-white-50 small">Angkatan {{ $alumniItem->angkatan }}</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        @if($alumniItem->pekerjaan || $alumniItem->perusahaan)
                                            <p class="mb-2 fw-semibold" style="color: var(--primary-color);">
                                                <i class="fas fa-briefcase me-2"></i>
                                                @if($alumniItem->pekerjaan && $alumniItem->perusahaan)
                                                    {{ $alumniItem->pekerjaan }} di {{ $alumniItem->perusahaan }}
                                                @elseif($alumniItem->pekerjaan)
                                                    {{ $alumniItem->pekerjaan }}
                                                @else
                                                    {{ $alumniItem->perusahaan }}
                                                @endif
                                            </p>
                                        @endif

                                        @if($alumniItem->testimoni)
                                            <div class="text-muted small fst-italic mb-0">
                                                <i class="fas fa-quote-left me-2" style="color: var(--accent-color);"></i>
                                                {{ \Illuminate\Support\Str::limit($alumniItem->testimoni, 150) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="px-4 pb-4">
                                        <a href="#" class="btn btn-sm btn-outline-brand w-100" data-bs-toggle="modal" data-bs-target="#alumniModal{{ $alumniItem->id }}">
                                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="alumniModal{{ $alumniItem->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content rounded-4 border-0">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold" style="color: var(--primary-color);">Kisah {{ $alumniItem->nama }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pt-2">
                                            <div class="row">
                                                <div class="col-md-4 text-center">
                                                    @if($alumniItem->foto)
                                                        <img src="{{ asset('storage/' . $alumniItem->foto) }}"
                                                             class="img-fluid rounded-circle mb-3 img-thumb-accent"
                                                             alt="{{ $alumniItem->nama }}"
                                                             style="width: 180px; height: 180px; object-fit: cover; border-bottom: none;">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center rounded-circle mx-auto mb-3"
                                                             style="width: 180px; height: 180px; background: var(--surface);">
                                                            <i class="fas fa-user-graduate fa-4x" style="color: var(--accent-color);"></i>
                                                        </div>
                                                    @endif
                                                    <h5 class="mb-1 fw-bold">{{ $alumniItem->nama }}</h5>
                                                    <p class="text-muted small mb-2">Angkatan {{ $alumniItem->angkatan }}</p>
                                                    @if($alumniItem->pekerjaan || $alumniItem->perusahaan)
                                                        <p class="small fw-semibold" style="color: var(--primary-color);">
                                                            <i class="fas fa-briefcase me-2"></i>
                                                            @if($alumniItem->pekerjaan && $alumniItem->perusahaan)
                                                                {{ $alumniItem->pekerjaan }} di {{ $alumniItem->perusahaan }}
                                                            @elseif($alumniItem->pekerjaan)
                                                                {{ $alumniItem->pekerjaan }}
                                                            @else
                                                                {{ $alumniItem->perusahaan }}
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Kisah Inspiratif</h6>
                                                    <div class="text-muted">
                                                        @if($alumniItem->deskripsi)
                                                            {!! $alumniItem->deskripsi !!}
                                                        @else
                                                            <p class="text-muted">Tidak ada deskripsi yang tersedia.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-outline-brand" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <span class="icon-circle mb-3" style="width: 72px; height: 72px; font-size: 1.8rem;">
                        <i class="fas fa-book-open"></i>
                    </span>
                    <h3 class="section-title">Belum Ada Cerita Alumni</h3>
                    <p class="text-muted">Cerita inspiratif dari alumni akan segera hadir</p>
                </div>
            @endforelse
        </div>
    </section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
