@extends('layout.app')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="page-header-band page-hero" style="--hero-photo: url('{{ asset('images/lab.jpg') }}');">
    <div class="container">
        <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="eyebrow" data-aos="fade-up"><i class="fas fa-handshake me-1"></i> Kolaborasi</span>
                <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
                    Tim <span class="text-gradient">Kolaborator</span> Proyek
                </h1>
                <p class="lead mx-auto mx-lg-0" style="max-width: 560px;" data-aos="fade-up" data-aos-delay="200">
                    Orang-orang luar biasa yang terlibat dalam pengembangan website LPSKE ini.
                </p>
            </div>
            <div class="col-lg-5 mx-auto text-center">
                <div class="hero3d-stage" data-aos="fade-left" data-aos-delay="150">
                    <span class="hero3d-orb o1"></span>
                    <span class="hero3d-orb o2"></span>
                    <div class="hero3d-tile tile-main g-primary" title="Kolaborasi"><i class="fas fa-handshake"></i></div>
                    <div class="hero3d-tile tile-1 g-secondary" title="Tim"><i class="fas fa-users"></i></div>
                    <div class="hero3d-tile tile-2 g-accent" title="Pengembangan"><i class="fas fa-code"></i></div>
                    <div class="hero3d-tile tile-3 g-light" title="Apresiasi"><i class="fas fa-star"></i></div>
                </div>
            </div>
            <div class="wave-divider-bottom">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.45,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C79.44,114.28,154.58,109.11,218.4,92.83c31.11-7.92,61.85-18.7,92.93-29.21Z" fill="rgba(239, 243, 252, 0.94)"></path>
                </svg>
            </div>
        </div>
    </div>
</section>

{{-- ===================== TABS & CONTRIBUTOR CARDS ===================== --}}
<section class="bg-particles" style="padding-top: 4rem; padding-bottom: 6rem;">
    <div class="container">

        {{-- Navigation Tabs --}}
        <ul class="nav nav-pills justify-content-center mb-5 gap-2 collab-tabs" id="kolaboratorTabs" role="tablist" data-aos="fade-up">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="smk2-tab" data-bs-toggle="tab" data-bs-target="#smk2" type="button" role="tab" aria-controls="smk2" aria-selected="true">
                    <i class="fas fa-school me-2"></i>SMK N 2 Surakarta
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="enuma-tab" data-bs-toggle="tab" data-bs-target="#enuma" type="button" role="tab" aria-controls="enuma" aria-selected="false">
                    <i class="fas fa-building me-2"></i>Enuma Technology
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="aslab-tab" data-bs-toggle="tab" data-bs-target="#aslab" type="button" role="tab" aria-controls="aslab" aria-selected="false">
                    <i class="fas fa-flask me-2"></i>Asisten Laboratorium LPSKE
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="mersif-tab" data-bs-toggle="tab" data-bs-target="#mersif" type="button" role="tab" aria-controls="mersif" aria-selected="false">
                    <i class="fas fa-microscope me-2"></i>Mersiflab
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ptik-tab" data-bs-toggle="tab" data-bs-target="#ptik" type="button" role="tab" aria-controls="ptik" aria-selected="false">
                    <i class="fas fa-laptop-code me-2"></i>PTIK
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="smkn6-tab" data-bs-toggle="tab" data-bs-target="#smkn6" type="button" role="tab" aria-controls="smkn6" aria-selected="false">
                    <i class="fas fa-school me-2"></i>SMK N 6 Surakarta
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sportflux-tab" data-bs-toggle="tab" data-bs-target="#sportflux" type="button" role="tab" aria-controls="sportflux" aria-selected="false">
                    <i class="fas fa-person-running me-2"></i>Sportflux
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="brainova-tab" data-bs-toggle="tab" data-bs-target="#brainova" type="button" role="tab" aria-controls="brainova" aria-selected="false">
                    <i class="fas fa-brain me-2"></i>Brainova
                </button>
            </li>
        </ul>

        <div class="tab-content" id="kolaboratorTabsContent">

            {{-- SMK N 2 Surakarta Tab --}}
            <div class="tab-pane fade show active" id="smk2" role="tabpanel" aria-labelledby="smk2-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <img src="{{ asset('images/fael.jpeg') }}" alt="Zafael Felix Putra Kurniawan" class="person-avatar" style="object-fit: cover;">
                                <h5 class="person-name">Zafael Felix Putra Kurniawan</h5>
                                <p class="person-role">Kelas 12 PPLG B/SMK N 2 Surakarta</p>
                                <div class="person-meta">
                                    <span class="badge-soft"><i class="fas fa-calendar-alt"></i> 2025/2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="80">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <img src="{{ asset('images/rayhan.jpeg') }}" alt="Rayhan Hafidz Adrian" class="person-avatar" style="object-fit: cover;">
                                <h5 class="person-name">Rayhan Hafidz Adrian</h5>
                                <p class="person-role">Kelas 12 PPLG B/SMK N 2 Surakarta</p>
                                <div class="person-meta">
                                    <span class="badge-soft"><i class="fas fa-calendar-alt"></i> 2025/2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="160">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <img src="{{ asset('images/eyud.jpeg') }}" alt="Philipus Radittya Tri Rudianto" class="person-avatar" style="object-fit: cover;">
                                <h5 class="person-name">Philipus Radittya Tri Rudianto</h5>
                                <p class="person-role">Kelas 12 PPLG B/SMK N 2 Surakarta</p>
                                <div class="person-meta">
                                    <span class="badge-soft"><i class="fas fa-calendar-alt"></i> 2025/2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="240">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <img src="{{ asset('images/bobby.jpeg') }}" alt="Ganendra Boby Enza Anshori" class="person-avatar" style="object-fit: cover;">
                                <h5 class="person-name">Ganendra Boby Enza Anshori</h5>
                                <p class="person-role">Kelas 12 PPLG A/SMK N 2 Surakarta</p>
                                <div class="person-meta">
                                    <span class="badge-soft"><i class="fas fa-calendar-alt"></i> 2025/2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="320">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <img src="{{ asset('images/bagas.jpg') }}" alt="Angga Bagas Pratama" class="person-avatar" style="object-fit: cover;">
                                <h5 class="person-name">Angga Bagas Pratama</h5>
                                <p class="person-role">Kelas 12 PPLG B/SMK N 2 Surakarta</p>
                                <div class="person-meta">
                                    <span class="badge-soft"><i class="fas fa-calendar-alt"></i> 2025/2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Enuma Technology Tab --}}
            <div class="tab-pane fade" id="enuma" role="tabpanel" aria-labelledby="enuma-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <img src="{{ asset('images/pakAndre.jpeg') }}" alt="Andreas Wegiq Adia Hendix" class="person-avatar" style="object-fit: cover;">
                                <h5 class="person-name">Andreas Wegiq Adia Hendix</h5>
                                <p class="person-role">Pimpinan Industri Enuma Technology</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Asisten Laboratorium LPSKE Tab --}}
            <div class="tab-pane fade" id="aslab" role="tabpanel" aria-labelledby="aslab-tab">
                <div class="row g-4">
                    @foreach(['Immanuel', 'Sheggy', 'Dzaki', 'Kezia', 'Citta', 'El Qonita', 'Nita', 'Zarith', 'Haris', 'Rafa'] as $i => $nama)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($i, 5) * 80 }}">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <div class="person-avatar">{{ strtoupper(substr($nama, 0, 1)) }}</div>
                                <h5 class="person-name">{{ $nama }}</h5>
                                <p class="person-role">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Mersiflab Tab --}}
            <div class="tab-pane fade" id="mersif" role="tabpanel" aria-labelledby="mersif-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <div class="person-avatar"><i class="fas fa-user-tie"></i></div>
                                <h5 class="person-name">Rozin</h5>
                                <p class="person-role">Pimpinan Mersiflab</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PTIK Tab --}}
            <div class="tab-pane fade" id="ptik" role="tabpanel" aria-labelledby="ptik-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <div class="person-avatar">AT</div>
                                <h5 class="person-name">Alan Tuguh</h5>
                                <p class="person-role">PTIK UNS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="80">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <img src="{{ asset('images/aldi.JPG') }}" alt="Muhamad Haikal" class="person-avatar" style="object-fit: cover;">
                                <h5 class="person-name">Muhamad Haikal</h5>
                                <p class="person-role">PTIK UNS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="160">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <div class="person-avatar">ND</div>
                                <h5 class="person-name">Naufal Daaris</h5>
                                <p class="person-role">PTIK UNS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SMK N 6 Surakarta Tab --}}
            <div class="tab-pane fade" id="smkn6" role="tabpanel" aria-labelledby="smkn6-tab">
                <div class="row g-4">
                    {{-- TODO: ganti dengan data kontributor asli --}}
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <div class="person-avatar">S</div>
                                <h5 class="person-name">Nama Kontributor</h5>
                                <p class="person-role">SMK N 6 Surakarta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sportflux Tab --}}
            <div class="tab-pane fade" id="sportflux" role="tabpanel" aria-labelledby="sportflux-tab">
                <div class="row g-4">
                    {{-- TODO: ganti dengan data kontributor asli --}}
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <div class="person-avatar">S</div>
                                <h5 class="person-name">Nama Kontributor</h5>
                                <p class="person-role">Sportflux</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Brainova Tab --}}
            <div class="tab-pane fade" id="brainova" role="tabpanel" aria-labelledby="brainova-tab">
                <div class="row g-4">
                    {{-- TODO: ganti dengan data kontributor asli --}}
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                        <div class="card-flat h-100 p-4">
                            <div class="person-card">
                                <div class="person-avatar">B</div>
                                <h5 class="person-name">Nama Kontributor</h5>
                                <p class="person-role">Brainova</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Thank You --}}
        <div class="card-flat p-4 p-md-5 text-center mt-5" data-aos="fade-up">
            <span class="icon-circle mb-3"><i class="fas fa-heart"></i></span>
            <h4 class="section-title mb-2">Terima Kasih</h4>
            <p class="text-muted mb-0 mx-auto" style="max-width: 640px;">
                Kepada semua pihak yang telah berkontribusi dalam pengembangan website LPSKE ini.
                Tanpa kerja sama dan dedikasi kalian, proyek ini tidak akan terwujud dengan baik.
            </p>
        </div>
    </div>
</section>

@push('styles')
<style>
    .collab-tabs .nav-link {
        color: var(--ink);
        font-weight: 600;
        font-size: 0.92rem;
        padding: 0.65rem 1.4rem;
        border-radius: 50px;
        border: 1px solid var(--glass-border);
        background: var(--glass-bg);
        -webkit-backdrop-filter: blur(12px) saturate(160%);
        backdrop-filter: blur(12px) saturate(160%);
        box-shadow: 0 0 0 1px var(--glass-edge);
        transition: all 0.25s ease;
    }
    .collab-tabs .nav-link:hover {
        background: rgba(79, 125, 243, 0.14);
        border-color: rgba(79, 125, 243, 0.45);
    }
    .collab-tabs .nav-link.active {
        background: linear-gradient(100deg, var(--primary-color), var(--primary-bright));
        border-color: transparent;
        color: #fff;
        box-shadow: 0 12px 26px rgba(47, 95, 224, 0.34);
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
