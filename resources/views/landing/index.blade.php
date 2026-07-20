@extends('layout.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section position-relative overflow-hidden" id="home" style="background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%); min-height: 80vh;">
        <div class="container py-5">
            <div class="row align-items-center justify-content-between flex-column-reverse flex-lg-row">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 fw-bold mb-4 animate_animated animate_fadeInDown" style="letter-spacing: -1px;">
                        Selamat Datang di <span class="text-primary">LPSKE</span>
                    </h1>
                    <p class="lead mb-4 animate_animated animate_fadeInUp" style="max-width: 500px;">
                        Laboratorium Perancangan Sistem Kerja dan Ergonomi (LPSKE) merupakan salah satu laboratorium unggulan di Jurusan Teknik Industri Universitas Sebelas Maret.
                    </p>
                    <div class="d-flex flex-wrap gap-3 animate_animated animate_fadeInUp">
                        <a href="#about" class="btn btn-gradient btn-lg shadow px-4 py-2" style="background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; border: none;">
                            <i class="fas fa-info-circle me-2"></i> Tentang Kami
                        </a>
                        
                    </div>
                </div>
                <div class="col-lg-5 mb-5 mb-lg-0 text-center animate_animated animate_zoomIn">
                    <div class="hero-img-wrapper position-relative">
                        <img src="{{ asset('images/title_lpske.png') }}" alt="LPSKE Hero Image" class="img-fluid rounded-4 shadow-lg" style="max-height: 350px; object-fit: contain;">
                        <div class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-primary shadow" style="font-size: 1rem; padding: 0.75em 1.5em;">
                            <i class="fas fa-flask me-2"></i> LPSKE
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <svg class="position-absolute bottom-0 start-0 w-100" height="80" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="z-index:1;">
            <path fill="#fff" fill-opacity="1" d="M0,64L48,58.7C96,53,192,43,288,53.3C384,64,480,96,576,101.3C672,107,768,85,864,74.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,160L1392,160C1344,160,1248,160,1152,160C1056,160,960,160,864,160C768,160,672,160,576,160C480,160,384,160,288,160C192,160,96,160,48,160L0,160Z"></path>
        </svg>
    </section>

    <!-- About Section -->
    <section class="py-5" id="about" style="background: #f8fafc;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="section-title mb-4 fw-bold text-primary" style="font-size:2.2rem;">
                        <i class="fas fa-users-cog me-2"></i> Tentang LPSKE
                    </h2>
                    <p class="mb-3 fs-5 text-dark">
                        Laboratorium Perancangan Sistem Kerja dan Ergonomi (LPSKE) merupakan salah satu dari enam laboratorium yang dimiliki oleh Teknik Industri Universitas Sebelas Maret. Laboratorium ini berfokus pada bidang keminatan rekayasa ergonomi, perancangan sistem kerja, serta manajemen lingkungan dalam keilmuan Teknik Industri.
                    </p>
                    <p class="fs-5 text-dark">
                        Kami berkomitmen untuk memberikan pendidikan, penelitian, dan pengabdian masyarakat yang berkualitas di bidang sistem kerja dan ergonomi untuk mendukung pengembangan sumber daya manusia yang unggul dan berdaya saing.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3 text-primary"><i class="fas fa-book-open me-2"></i> Mata Kuliah</h5>
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="text-muted mb-2">Wajib:</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="fas fa-check-circle text-success me-2"></i> Pengetahuan Lingkungan</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i> Ergonomi</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i> Psikologi Industri</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i> Pengantar Rekayasa Industri</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i> Analisis & Perancangan Sistem Kerja</li>
                                        <li><i class="fas fa-check-circle text-success me-2"></i> K3 (Keselamatan & Kesehatan Kerja)</li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-muted mb-2">Pilihan:</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="fas fa-star text-warning me-2"></i> Ergonomi Fisik</li>
                                        <li><i class="fas fa-star text-warning me-2"></i> Ergonomi Kognitif</li>
                                        <li><i class="fas fa-star text-warning me-2"></i> Ergonomi Lingkungan</li>
                                        <li><i class="fas fa-star text-warning me-2"></i> Ergonomi untuk Anak-anak</li>
                                        <li><i class="fas fa-star text-warning me-2"></i> Ergonomi untuk Berkebutuhan Khusus</li>
                                        <li><i class="fas fa-star text-warning me-2"></i> Perbaikan Metode Kerja</li>
                                        <li><i class="fas fa-star text-warning me-2"></i> Karakuri</li>
                                        <li><i class="fas fa-star text-warning me-2"></i> Aplikasi Ergonomi Industri</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Logbook Section -->


    <!-- Facilities Section -->
    <section class="py-5" id="facilities" style="background: #f8fafc;">
        <div class="container">
            <h2 class="section-title text-center fw-bold text-primary mb-5"><i class="fas fa-building me-2"></i> Fasilitas & SOP</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-lg border-0 rounded-4 hover-shadow transition-all">
                        <div class="position-relative">
                            
                            <span class="badge bg-gradient-primary position-absolute top-0 end-0 m-3" style="background: linear-gradient(90deg,#007bff,#00c6ff);color:#fff;">Sistem kerja</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Laboratorium </h5>
                            <p class="card-text">Dilengkapi dengan peralatan pengukuran antropometri dan analisis postur kerja.</p>
                            <button type="button" class="btn btn-gradient w-100 mt-2" data-bs-toggle="modal" data-bs-target="#sopModal1" style="background: linear-gradient(90deg,#007bff,#00c6ff);color:#fff;">
                                <i class="fas fa-file-alt me-2"></i> Lihat SOP
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-lg border-0 rounded-4 hover-shadow transition-all">
                        <div class="position-relative">
                            
                            <span class="badge bg-gradient-primary position-absolute top-0 end-0 m-3" style="background: linear-gradient(90deg,#007bff,#00c6ff);color:#fff;">Laboran</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Ruang Laboran</h5>
                            <p class="card-text">Didalamnya terdapat ruang iklim dan ruang dosen.</p>
                            <button type="button" class="btn btn-gradient w-100 mt-2" data-bs-toggle="modal" data-bs-target="#sopModal2" style="background: linear-gradient(90deg,#007bff,#00c6ff);color:#fff;">
                                <i class="fas fa-file-alt me-2"></i> Lihat SOP
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-lg border-0 rounded-4 hover-shadow transition-all">
                        <div class="position-relative">
                            
                            <span class="badge bg-gradient-primary position-absolute top-0 end-0 m-3" style="background: linear-gradient(90deg,#007bff,#00c6ff);color:#fff;">Diskusi</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Ruang Rapat</h5>
                            <p class="card-text">Tempat diskusi dan presentasi untuk mahasiswa dan peneliti .</p>
                            <button type="button" class="btn btn-gradient w-100 mt-2" data-bs-toggle="modal" data-bs-target="#sopModal3" style="background: linear-gradient(90deg,#007bff,#00c6ff);color:#fff;">
                                <i class="fas fa-file-alt me-2"></i> Lihat SOP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include SOP Modals -->
    @include('landing.sop_modals')

    <!-- Asisten Laboratorium Section -->
    <section class="py-5" id="asisten" style="background: linear-gradient(120deg, #e0eafc 0%, #f8fafc 100%);">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0 fw-bold text-primary"><i class="fas fa-user-friends me-2"></i> Asisten Laboratorium</h2>
                <a href="{{ route('asisten-laboratorium') }}" class="btn btn-gradient px-4" style="background: linear-gradient(90deg,#007bff,#00c6ff);color:#fff;">
                    <i class="fas fa-users me-2"></i> Lihat Semua
                </a>
            </div>
            <div class="row g-4">
                @forelse($asisten as $asistenItem)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg rounded-4 hover-shadow transition-all">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fas fa-user-graduate text-white"></i>
                                </div>
                                <div>
                                    <h6 class="card-title fw-bold text-primary mb-0">{{ $asistenItem->name }}</h6>
                                    <small class="text-muted">Asisten LPSKE</small>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        @if($asistenItem->nim)
                                        <tr>
                                            <td class="text-muted" style="width: 30px;"><i class="fas fa-id-card"></i></td>
                                            <td class="text-muted small">NIM:</td>
                                            <td class="small">{{ $asistenItem->nim }}</td>
                                        </tr>
                                        @endif
                                        @if($asistenItem->angkatan)
                                        <tr>
                                            <td class="text-muted"><i class="fas fa-calendar-alt"></i></td>
                                            <td class="text-muted small">Angkatan:</td>
                                            <td class="small">{{ $asistenItem->angkatan }}</td>
                                        </tr>
                                        @endif
                                        @if($asistenItem->study_program)
                                        <tr>
                                            <td class="text-muted"><i class="fas fa-graduation-cap"></i></td>
                                            <td class="text-muted small">Program:</td>
                                            <td class="small">{{ $asistenItem->study_program }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">Data asisten belum tersedia</div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    

    <!-- Featured Content Section -->
    <section class="py-5" id="prestasi-kegiatan" style="background: linear-gradient(120deg, #e0eafc 0%, #f8fafc 100%);">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0 fw-bold text-primary"><i class="fas fa-trophy me-2"></i> Prestasi & Kegiatan</h2>
                <a href="{{ route('prestasi-kegiatan.index') }}" class="btn btn-gradient px-4" style="background: linear-gradient(90deg,#007bff,#00c6ff);color:#fff;">
                    <i class="fas fa-list me-2"></i> Lihat Semua
                </a>
            </div>
            <div class="row g-4">
                @forelse($featuredItems as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-lg border-0 rounded-4 hover-shadow transition-all">
                        @if($item->is_video)
                            <div class="ratio ratio-16x9 rounded-top-4 overflow-hidden">
                                <iframe 
                                    src="{{ $item->video_url }}" 
                                    title="{{ $item->judul }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    style="border-radius: 1rem 1rem 0 0;">
                                </iframe>
                            </div>
                        @else
                            <img src="{{ $item->gambar_url }}" class="card-img-top rounded-top-4" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge {{ $item->jenis === 'prestasi' ? 'bg-success' : 'bg-info' }} text-uppercase px-3 py-2" style="font-size:0.9em;">
                                    <i class="fas {{ $item->jenis === 'prestasi' ? 'fa-trophy' : 'fa-bolt' }} me-1"></i>
                                    {{ ucfirst($item->jenis) }}
                                </span>
                                @if($item->is_featured)
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-star me-1"></i> Tampil di Beranda
                                    </span>
                                @endif
                            </div>
                            <h5 class="card-title fw-bold text-primary">{{ $item->judul }}</h5>
                            @if($item->deskripsi)
                                <p class="card-text text-dark">{{ Str::limit($item->deskripsi, 100) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>{{ $item->tanggal->format('d M Y') }}</small>
                                <a href="{{ route('prestasi-kegiatan.show', $item) }}" class="btn btn-sm btn-outline-primary px-3">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Belum ada konten yang ditampilkan</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Alumni Modal (Gallery) -->
    @for($i = 1; $i <= 4; $i++)
    <div class="modal fade" id="alumni{{ $i }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-primary">Alumni {{ $i }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('images/gallery-' . $i . '.jpg') }}" class="img-fluid rounded-4 shadow" alt="Gallery {{ $i }}">
                </div>
            </div>
        </div>
    </div>
    @endfor

    <section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <div class="me-3" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="font-size: 24px; color: white;"></i>
                    </div>
                    <div>
                        <h3 class="mb-2 fw-bold">Kolaborasi Proyek</h3>
                        <p class="mb-0 opacity-75">Proyek ini merupakan hasil kolaborasi tim yang luar biasa</p>
                    </div>
                </div>
                
                <p class="lead mb-4 opacity-90">
                    Website LPSKE ini dikembangkan melalui kerja sama yang solid antara berbagai pihak yang berkontribusi dalam pengembangan sistem informasi laboratorium.
                </p>
                
                <div class="mb-4" style="display: grid; grid-template-columns: repeat(8, 90px); justify-content: center; gap: 24px;">
                    <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255, 255, 255, 0.5);">
                        <img src="{{ asset('images/smk2ska.png') }}" alt="Kolaborator 1" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>

                    <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255, 255, 255, 0.5);">
                        <img src="{{ asset('images/enuma.jfif') }}" alt="Kolaborator 2" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>

                    <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255, 255, 255, 0.5);">
                        <img src="{{ asset('images/title_lpske.png') }}" alt="Kolaborator 3" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>

                    <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255, 255, 255, 0.5);">
                        <img src="{{ asset('images/mers.jfif') }}" alt="Kolaborator 4" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>

                    <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255, 255, 255, 0.5);">
                        <img src="{{ asset('images/Ptik uns.png') }}" alt="Kolaborator 5" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>

                    <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255, 255, 255, 0.5);">
                        <img src="{{ asset('images/Smk6.png') }}" alt="Kolaborator 6" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>

                    <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255, 255, 255, 0.5);">
                        <img src="{{ asset('images/Sportflux.png') }}" alt="Kolaborator 7" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>

                    <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; border: 3px solid rgba(255, 255, 255, 0.5);">
                        <img src="{{ asset('images/Brainova.png') }}" alt="Kolaborator 8" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                </div>
                
                <a href="{{ route('kolaborator') }}" class="btn btn-light btn-lg px-2 py-1 shadow-sm" style="border-radius: 50px;">
                    <i class="fas fa-eye sm-1"></i> see more
                </a>
            </div>
        </div>
    </div>


        
        <!-- Decorative elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0; opacity: 0.1;">
            <div class="position-absolute" style="top: 20%; left: 10%; width: 100px; height: 100px; background: white; border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
            <div class="position-absolute" style="top: 60%; right: 15%; width: 60px; height: 60px; background: white; border-radius: 50%; animation: float 8s ease-in-out infinite reverse;"></div>
            <div class="position-absolute" style="bottom: 20%; left: 20%; width: 80px; height: 80px; background: white; border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
        </div>
    </section>

    {{-- Custom CSS for UI/UX upgrade --}}
    <style>
        .btn-gradient {
            background: linear-gradient(90deg,#007bff,#00c6ff);
            color: #fff;
            border: none;
            transition: background 0.3s, color 0.3s, box-shadow 0.3s;
        }
        .btn-gradient:hover, .btn-gradient:focus {
            background: linear-gradient(90deg,#0056b3,#00aaff);
            color: #fff;
            box-shadow: 0 4px 16px rgba(0,123,255,0.15);
        }
        .hover-shadow:hover, .hover-shadow:focus {
            box-shadow: 0 8px 32px rgba(0,123,255,0.15) !important;
            transform: translateY(-4px) scale(1.02);
        }
        .transition-all {
            transition: all 0.3s cubic-bezier(.4,2,.3,1);
        }
        .rounded-4 {
            border-radius: 1.25rem !important;
        }
        .bg-gradient-primary {
            background: linear-gradient(90deg,#007bff,#00c6ff) !important;
            color: #fff !important;
        }
        .timeline {
            position: relative;
        }
        .timeline-item {
            position: relative;
            padding-left: 30px;
        }
        .timeline-item:before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            width: 10px;
            height: 10px;
            background: #007bff;
            border-radius: 50%;
            z-index: 2;
        }
        .timeline-item:not(:last-child):after {
            content: '';
            position: absolute;
            left: 14px;
            top: 10px;
            width: 2px;
            height: calc(100% - 10px);
            background: #e0eafc;
            z-index: 1;
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        @media (max-width: 991.98px) {
            .hero-section .display-3 {
                font-size: 2.2rem;
            }
        }
    </style>
    {{-- Animate.css CDN for subtle animations --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection