@extends('layout.app')

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="section-title">Tim Kolaborator Proyek</h1>
        <p class="lead mb-5 text-muted">Orang-orang luar biasa yang terlibat dalam pengembangan website LPSKE ini</p>
        
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs mb-4" id="kolaboratorTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" 
                        id="smk2-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#smk2" 
                        type="button" 
                        role="tab" 
                        aria-controls="smk2" 
                        aria-selected="true">
                    SMK N 2 Surakarta
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="enuma-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#enuma" 
                        type="button" 
                        role="tab" 
                        aria-controls="enuma" 
                        aria-selected="false">
                    Enuma Technology
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="aslab-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#aslab" 
                        type="button" 
                        role="tab" 
                        aria-controls="aslab" 
                        aria-selected="false">
                    Asisten Laboratorium LPSKE
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="mersif-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#mersif" 
                        type="button" 
                        role="tab" 
                        aria-controls="mersif" 
                        aria-selected="false">
                    Mersiflab
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="ptik-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#ptik" 
                        type="button" 
                        role="tab" 
                        aria-controls="ptik" 
                        aria-selected="false">
                    PTIK
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="smkn6-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#smkn6" 
                        type="button" 
                        role="tab" 
                        aria-controls="smkn6" 
                        aria-selected="false">
                    SMK N 6 Surakarta
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="sportflux-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#sportflux" 
                        type="button" 
                        role="tab" 
                        aria-controls="sportflux" 
                        aria-selected="false">
                    Sportflux
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="brainova-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#brainova" 
                        type="button" 
                        role="tab" 
                        aria-controls="brainova" 
                        aria-selected="false">
                    Brainova
                </button>
            </li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content" id="kolaboratorTabsContent">
            <!-- Developer Tab -->
            <div class="tab-pane fade show active" 
                 id="smk2" 
                 role="tabpanel" 
                 aria-labelledby="smk2-tab">
                <div class="row g-4">
                <div class="col-md-6 col-lg-4">
    <div class="card h-100 shadow-sm hover-shadow transition-all">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="{{ asset('images/fael.jpeg') }}" alt="Foto Saya" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
                                <h5 class="card-title">Zafael Felix Putra Kurniawan</h5>
                                <p class="text-muted mb-2">Kelas 12 PPLG B/SMK N 2 Surakarta</p>
                                <p>2025/2026</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-shadow transition-all">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="{{ asset('images/rayhan.jpeg') }}" alt="Foto Saya" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
                                <h5 class="card-title">Rayhan Hafidz Adrian</h5>
                                <p class="text-muted mb-2">Kelas 12 PPLG B/SMK N 2 Surakarta</p>
                                <p>2025/2026</p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
    <div class="card h-100 shadow-sm hover-shadow transition-all">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="{{ asset('images/eyud.jpeg') }}" alt="Foto Saya" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
                                <h5 class="card-title">Philipus Radittya Tri Rudianto</h5>
                                <p class="text-muted mb-2">Kelas 12 PPLG B/SMK N 2 Surakarta</p>
                                <p>2025/2026</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
    <div class="card h-100 shadow-sm hover-shadow transition-all">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="{{ asset('images/bobby.jpeg') }}" alt="Foto Saya" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
                                <h5 class="card-title">Ganendra Boby Enza Anshori</h5>
                                <p class="text-muted mb-2">Kelas 12 PPLG A/SMK N 2 Surakarta</p>
                                <p>2025/2026</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
    <div class="card h-100 shadow-sm hover-shadow transition-all">
        <div class="card-body text-center">
            <div class="mb-3">
                <img src="{{ asset('images/bagas.jpg') }}" alt="Foto Saya" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
                                <h5 class="card-title"> Angga Bagas Pratama</h5>
                                <p class="text-muted mb-2">Kelas 12 PPLG B/SMK N 2 Surakarta</p>
                                <p>2025/2026</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            
           <!-- Designer Tab -->
<div class="tab-pane fade" 
     id="enuma" 
     role="tabpanel" 
     aria-labelledby="enuma-tab">
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-shadow transition-all">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <!-- Foto profil -->
                        <img src="{{ asset('images/pakAndre.jpeg') }}" 
                             alt="Foto saya" 
                             class="rounded-circle" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <h5 class="card-title">Andreas Wegiq Adia Hendix</h5>
                    <p class="text-muted mb-2">Pimpinan Industri Enuma Technology</p>
                </div>
            </div>
        </div>
    </div>
</div>

            
            <!-- Supervisor Tab -->
            <div class="tab-pane fade" 
                 id="aslab" 
                 role="tabpanel" 
                 aria-labelledby="aslab-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-info bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        I
                                    </div>
                                </div>
                                <h5 class="card-title">Immanuel</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-primary bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        S
                                    </div>
                                </div>
                                <h5 class="card-title">Sheggy</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-success bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        D
                                    </div>
                                </div>
                                <h5 class="card-title">Dzaki</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-warning bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        K
                                    </div>
                                </div>
                                <h5 class="card-title">Kezia</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-danger bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        C
                                    </div>
                                </div>
                                <h5 class="card-title">Citta</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-info bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        E
                                    </div>
                                </div>
                                <h5 class="card-title">El Qonita</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-primary bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        N
                                    </div>
                                </div>
                                <h5 class="card-title">Nita</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-success bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        Z
                                    </div>
                                </div>
                                <h5 class="card-title">Zarith</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-danger bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        H
                                    </div>
                                </div>
                                <h5 class="card-title">Haris</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-warning bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        R
                                    </div>
                                </div>
                                <h5 class="card-title">Rafa</h5>
                                <p class="text-muted mb-2">Asisten Lab Lpske</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mersiflab Tab -->
            <div class="tab-pane fade" 
                 id="mersif" 
                 role="tabpanel" 
                 aria-labelledby="mersif-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-info bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="fas fa-user-tie text-white" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <h5 class="card-title">Rozin</h5>
                                <p class="text-muted mb-2">Pimpinan Mersiflab</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PTIK Tab -->
            <div class="tab-pane fade" 
                 id="ptik" 
                 role="tabpanel" 
                 aria-labelledby="ptik-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-primary bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        P
                                    </div>
                                </div>
                                <h5 class="card-title">Nama Kontributor</h5>
                                <p class="text-muted mb-2">PTIK</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SMK N 6 Surakarta Tab -->
            <div class="tab-pane fade" 
                 id="smkn6" 
                 role="tabpanel" 
                 aria-labelledby="smkn6-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-success bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        S
                                    </div>
                                </div>
                                <h5 class="card-title">Nama Kontributor</h5>
                                <p class="text-muted mb-2">SMK N 6 Surakarta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sportflux Tab -->
            <div class="tab-pane fade" 
                 id="sportflux" 
                 role="tabpanel" 
                 aria-labelledby="sportflux-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-warning bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        S
                                    </div>
                                </div>
                                <h5 class="card-title">Nama Kontributor</h5>
                                <p class="text-muted mb-2">Sportflux</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brainova Tab -->
            <div class="tab-pane fade" 
                 id="brainova" 
                 role="tabpanel" 
                 aria-labelledby="brainova-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-danger bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem; color: #fff; font-weight: bold;">
                                        B
                                    </div>
                                </div>
                                <h5 class="card-title">Nama Kontributor</h5>
                                <p class="text-muted mb-2">Brainova</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Thank You Section -->
        <div class="mt-5 p-4 bg-light rounded-4">
            <div class="text-center">
                <h4 class="text-primary mb-3">
                    Terima Kasih
                </h4>
                <p class="mb-0 text-muted">
                    Kepada semua pihak yang telah berkontribusi dalam pengembangan website LPSKE ini. 
                    Tanpa kerja sama dan dedikasi kalian, proyek ini tidak akan terwujud dengan baik.
                </p>
            </div>
        </div>
    </div>
</section>
            
            <!-- Mersiflab Tab -->
            <div class="tab-pane fade" 
                 id="mersif" 
                 role="tabpanel" 
                 aria-labelledby="mersif-tab">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-shadow transition-all">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="rounded-circle bg-info bg-gradient d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="fas fa-user-tie text-white" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <h5 class="card-title">Rozin</h5>
                                <p class="text-muted mb-2">Pimpinan Mersiflab</p>
                             
                            </div>
                        </div>
                    </div>
                    
                   
        
        <!-- Thank You Section -->
        <div class="mt-5 p-4 bg-light rounded-4">
            <div class="text-center">
                <h4 class="text-primary mb-3">
                    <i class="fas fa-heart text-danger me-2"></i>
                    Terima Kasih
                </h4>
                <p class="mb-0 text-muted">
                    Kepada semua pihak yang telah berkontribusi dalam pengembangan website LPSKE ini. 
                    Tanpa kerja sama dan dedikasi kalian, proyek ini tidak akan terwujud dengan baik.
                </p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Add hover effects and smooth transitions
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.hover-shadow');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endpush

<style>
    .section-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .hover-shadow {
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .transition-all {
        transition: all 0.3s ease;
    }
    
    .nav-tabs .nav-link {
        color: var(--primary-color);
        border: none;
        border-bottom: 2px solid transparent;
        font-weight: 500;
    }
    
    .nav-tabs .nav-link.active {
        background-color: transparent;
        border-bottom-color: var(--primary-color);
        color: var(--primary-color);
    }
    
    .nav-tabs .nav-link:hover {
        border-bottom-color: var(--primary-color);
        color: var(--primary-color);
    }
</style>
@endsection