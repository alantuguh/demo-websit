@extends('layout.app')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="position-relative overflow-hidden" style="background: linear-gradient(360deg, rgba(195, 208, 227, 0.5) 0%, #aebfda 100%); padding: 110px 0 70px;">
    <div class="container text-center">
        <span class="eyebrow" data-aos="fade-up"><i class="fas fa-users me-1"></i> Tim Kami</span>
        <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
            Tim <span class="text-gradient">Laboratorium</span>
        </h1>
        <p class="lead mx-auto" style="max-width: 620px; color: var(--ink);" data-aos="fade-up" data-aos-delay="200">
            Kepala laboratorium, dosen pembina, dan asisten yang mendukung kegiatan akademik, praktikum, serta penelitian di LPSKE.
        </p>
    </div>
</section>

<section class="py-5 bg-particles" style="padding-top: 4rem !important; padding-bottom: 6rem !important;">
    <div class="container">

        {{-- Navigation Tabs --}}
        <ul class="nav nav-pills justify-content-center mb-5 gap-2 lab-tabs" id="labTabs" role="tablist" data-aos="fade-up">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeMenu === 'kepala' ? 'active' : '' }}"
                        id="kepala-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#kepala"
                        type="button"
                        role="tab"
                        aria-controls="kepala"
                        aria-selected="{{ $activeMenu === 'kepala' ? 'true' : 'false' }}">
                    <i class="fas fa-user-tie me-2"></i>Kepala Laboratorium
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeMenu === 'dosen' ? 'active' : '' }}"
                        id="dosen-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#dosen"
                        type="button"
                        role="tab"
                        aria-controls="dosen"
                        aria-selected="{{ $activeMenu === 'dosen' ? 'true' : 'false' }}">
                    <i class="fas fa-chalkboard-teacher me-2"></i>Dosen Laboratorium
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ str_starts_with($activeMenu, 'asisten') ? 'active' : '' }}"
                        id="asisten-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#asisten"
                        type="button"
                        role="tab"
                        aria-controls="asisten"
                        aria-selected="{{ str_starts_with($activeMenu, 'asisten') ? 'true' : 'false' }}">
                    <i class="fas fa-user-graduate me-2"></i>Asisten Laboratorium
                </button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="labTabsContent">
            {{-- Kepala Laboratorium Tab --}}
            <div class="tab-pane fade {{ $activeMenu === 'kepala' ? 'show active' : '' }}"
                 id="kepala"
                 role="tabpanel"
                 aria-labelledby="kepala-tab">
                @if(isset($kepala) && $kepala)
                <div class="row justify-content-center">
                    <div class="col-lg-8" data-aos="fade-up">
                        <div class="card-flat overflow-hidden">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img src="{{ $kepala->photo ? asset('storage/' . $kepala->photo) : asset('images/avatar-placeholder.png') }}"
                                         class="w-100 h-100 img-thumb-accent"
                                         alt="{{ $kepala->name }}"
                                         style="object-fit: cover; min-height: 260px;">
                                </div>
                                <div class="col-md-7">
                                    <div class="p-4">
                                        <span class="eyebrow mb-1">{{ $kepala->position ?? 'Kepala Laboratorium' }}</span>
                                        <h3 class="fw-bold mb-1" style="color: var(--ink);">{{ $kepala->name }}</h3>
                                        <hr>
                                        <dl class="row mb-0">
                                            @if($kepala->nip)
                                            <dt class="col-sm-4 text-muted">NIP</dt>
                                            <dd class="col-sm-8">{{ $kepala->nip }}</dd>
                                            @endif
                                            @if($kepala->expertise)
                                            <dt class="col-sm-4 text-muted">Bidang Keahlian</dt>
                                            <dd class="col-sm-8">{{ $kepala->expertise }}</dd>
                                            @endif
                                        </dl>

                                        @if($kepala->bio)
                                        <div class="mt-3">
                                            <h6 class="fw-bold" style="color: var(--primary-color);">Tentang:</h6>
                                            <div class="text-muted">{!! $kepala->bio !!}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-info text-center">Data kepala laboratorium belum tersedia.</div>
                @endif
            </div>

            {{-- Dosen Laboratorium Tab --}}
            <div class="tab-pane fade {{ $activeMenu === 'dosen' ? 'show active' : '' }}"
                 id="dosen"
                 role="tabpanel"
                 aria-labelledby="dosen-tab">
                @if(isset($dosen) && $dosen->count() > 0)
                <div class="row g-4">
                    @foreach($dosen as $d)
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                        <div class="card-flat h-100 overflow-hidden">
                            <div class="row g-0 h-100">
                                <div class="col-md-4">
                                    <img src="{{ $d->photo ? asset('storage/' . $d->photo) : asset('images/avatar-placeholder.png') }}"
                                         class="w-100 h-100 img-thumb-accent"
                                         alt="{{ $d->name }}"
                                         style="object-fit: cover; min-height: 180px;">
                                </div>
                                <div class="col-md-8">
                                    <div class="p-4">
                                        <h5 class="fw-bold mb-1" style="color: var(--ink);">{{ $d->name }}</h5>
                                        <p class="text-muted small mb-2">{{ $d->position ?? 'Dosen Laboratorium' }}</p>
                                        <hr class="my-2">
                                        <dl class="row mb-0 small">
                                            @if($d->nip)
                                            <dt class="col-sm-4 text-muted">NIP</dt>
                                            <dd class="col-sm-8">{{ $d->nip }}</dd>
                                            @endif
                                            @if($d->expertise)
                                            <dt class="col-sm-4 text-muted">Bidang</dt>
                                            <dd class="col-sm-8">{{ $d->expertise }}</dd>
                                            @endif
                                        </dl>

                                        @if($d->bio)
                                        <div class="mt-2">
                                            <div class="text-muted small">{!! $d->bio !!}</div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-info text-center">Data dosen laboratorium belum tersedia.</div>
                @endif
            </div>

            {{-- Asisten Laboratorium Tab --}}
            <div class="tab-pane fade {{ str_starts_with($activeMenu, 'asisten') ? 'show active' : '' }}"
                 id="asisten"
                 role="tabpanel"
                 aria-labelledby="asisten-tab">
                {{-- Angkatan Filter --}}
                @if(isset($angkatanList) && $angkatanList->count() > 0)
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up">
                    <a href="{{ route('asisten-laboratorium') }}"
                       class="btn {{ is_null($angkatan) ? 'btn-brand' : 'btn-outline-brand' }} btn-sm px-3">
                        Semua
                    </a>
                    @foreach($angkatanList as $tahun)
                    <a href="{{ route('asisten.angkatan', ['angkatan' => $tahun]) }}"
                       class="btn {{ isset($angkatan) && $angkatan == $tahun ? 'btn-brand' : 'btn-outline-brand' }} btn-sm px-3">
                        Angkatan {{ $tahun }}
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- Asisten List --}}
                @if(isset($asisten) && $asisten->count() > 0)
                <div class="row g-4">
                    @foreach($asisten as $a)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                        <div class="card-flat h-100 p-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="icon-circle me-3"><i class="fas fa-user-graduate"></i></span>
                                <div>
                                    <h6 class="fw-bold mb-0" style="color: var(--ink);">{{ $a->name }}</h6>
                                    <small class="text-muted">Asisten LPSKE</small>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        @if($a->nim)
                                        <tr>
                                            <td class="text-muted ps-0" style="width: 28px;"><i class="fas fa-id-card"></i></td>
                                            <td class="text-muted small">NIM:</td>
                                            <td class="small">{{ $a->nim }}</td>
                                        </tr>
                                        @endif
                                        @if($a->angkatan)
                                        <tr>
                                            <td class="text-muted ps-0"><i class="fas fa-calendar-alt"></i></td>
                                            <td class="text-muted small">Angkatan:</td>
                                            <td class="small">{{ $a->angkatan }}</td>
                                        </tr>
                                        @endif
                                        @if($a->study_program)
                                        <tr>
                                            <td class="text-muted ps-0"><i class="fas fa-graduation-cap"></i></td>
                                            <td class="text-muted small">Program:</td>
                                            <td class="small">{{ $a->study_program }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-info text-center">Tidak ada data asisten yang tersedia.</div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .lab-tabs .nav-link {
        color: var(--ink);
        font-weight: 600;
        font-size: 0.92rem;
        padding: 0.65rem 1.4rem;
        border-radius: 50px;
        border: 2px solid var(--primary-color);
        background: transparent;
        transition: all 0.25s ease;
    }
    .lab-tabs .nav-link:hover {
        background: rgba(82, 103, 132, 0.08);
    }
    .lab-tabs .nav-link.active {
        background: var(--primary-color);
        color: #fff;
        box-shadow: 0 10px 22px rgba(82, 103, 132, 0.3);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash) {
            const tabTrigger = document.querySelector(`[data-bs-target="${hash}"]`);
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }
    });
</script>
@endpush
@endsection
