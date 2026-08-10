@extends('layout.app')

@section('content')

    {{-- ===================== HERO ===================== --}}
    {{-- Tanpa --hero-photo: latar hero sepenuhnya video + gradien aurora.
         (.page-hero sudah punya fallback `var(--hero-photo, none)`.) --}}
    <section class="page-hero" id="home">
        @include('partials.hero-video')

        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">
                <div class="col-lg-6 text-center text-lg-start">
                    <span class="eyebrow" data-aos="fade-up"><i class="fas fa-flask me-1"></i> Laboratorium Teknik Industri &middot; UNS Surakarta</span>
                    <h1 class="display-4 fw-bold mb-4" style="letter-spacing: -1px; line-height: 1.15;" data-aos="fade-up" data-aos-delay="100">
                        Selamat Datang di <span class="text-gradient">LPSKE</span>
                    </h1>
                    <p class="lead mb-4 mx-auto mx-lg-0" style="max-width: 520px;" data-aos="fade-up" data-aos-delay="200">
                        Laboratorium Perancangan Sistem Kerja dan Ergonomi (LPSKE) merupakan salah satu laboratorium unggulan di Jurusan Teknik Industri Universitas Sebelas Maret.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3" data-aos="fade-up" data-aos-delay="300">
                        <a href="#about" class="btn btn-brand btn-lg px-4">
                            <i class="fas fa-info-circle me-2"></i> Tentang Kami
                        </a>
                        <a href="{{ route('prestasi-kegiatan.index') }}" class="btn btn-outline-brand btn-lg px-4">
                            <i class="fas fa-trophy me-2"></i> Prestasi & Kegiatan
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 mx-auto text-center">
                    <div class="hero3d-stage" data-aos="fade-left" data-aos-delay="150">
                        <span class="hero3d-orb o1"></span>
                        <span class="hero3d-orb o2"></span>
                        <div class="hero3d-tile tile-main g-primary" title="Ergonomi"><img src="{{ asset('images/title_lpske.png') }}"></img></div>
                        <div class="hero3d-tile tile-1 g-secondary" title="Laboratorium"><i class="fas fa-flask"></i></div>
                        <div class="hero3d-tile tile-2 g-accent" title="Antropometri"><i class="fas fa-ruler-combined"></i></div>
                        <div class="hero3d-tile tile-3 g-light" title="Sistem Kerja"><i class="fas fa-gear"></i></div>
                        <span class="hero3d-badge"><i class="fas fa-flask me-1"></i> LPSKE</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== ABOUT ===================== --}}
    <section class="py-5 bg-particles" id="about" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="eyebrow">Sekilas Tentang Kami</span>
                    <h2 class="section-title mb-4" style="font-size: 2.1rem;">Tentang LPSKE</h2>
                    <p class="mb-3 fs-5" style="color: var(--muted);">
                        Laboratorium Perancangan Sistem Kerja dan Ergonomi (LPSKE) merupakan salah satu dari enam laboratorium yang dimiliki oleh Teknik Industri Universitas Sebelas Maret. Laboratorium ini berfokus pada bidang keminatan rekayasa ergonomi, perancangan sistem kerja, serta manajemen lingkungan dalam keilmuan Teknik Industri.
                    </p>
                    <p class="fs-5" style="color: var(--muted);">
                        Kami berkomitmen untuk memberikan pendidikan, penelitian, dan pengabdian masyarakat yang berkualitas di bidang sistem kerja dan ergonomi untuk mendukung pengembangan sumber daya manusia yang unggul dan berdaya saing.
                    </p>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                    <div class="card-flat p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--primary-color);"><i class="fas fa-book-open me-2"></i> Mata Kuliah</h5>
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-muted mb-2 small text-uppercase">Wajib</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="list-row"><i class="fas fa-check-circle text-success me-2"></i> Pengetahuan Lingkungan</li>
                                    <li class="list-row"><i class="fas fa-check-circle text-success me-2"></i> Ergonomi</li>
                                    <li class="list-row"><i class="fas fa-check-circle text-success me-2"></i> Psikologi Industri</li>
                                    <li class="list-row"><i class="fas fa-check-circle text-success me-2"></i> Pengantar Rekayasa Industri</li>
                                    <li class="list-row"><i class="fas fa-check-circle text-success me-2"></i> Analisis & Perancangan Sistem Kerja</li>
                                    <li class="list-row"><i class="fas fa-check-circle text-success me-2"></i> K3 (Keselamatan & Kesehatan Kerja)</li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted mb-2 small text-uppercase">Pilihan</h6>
                                <ul class="list-unstyled mb-0">
                                    <li class="list-row list-row-accent"><i class="fas fa-star me-2" style="color: var(--secondary-color);"></i> Ergonomi Fisik</li>
                                    <li class="list-row list-row-accent"><i class="fas fa-star me-2" style="color: var(--secondary-color);"></i> Ergonomi Kognitif</li>
                                    <li class="list-row list-row-accent"><i class="fas fa-star me-2" style="color: var(--secondary-color);"></i> Ergonomi Lingkungan</li>
                                    <li class="list-row list-row-accent"><i class="fas fa-star me-2" style="color: var(--secondary-color);"></i> Ergonomi untuk Anak-anak</li>
                                    <li class="list-row list-row-accent"><i class="fas fa-star me-2" style="color: var(--secondary-color);"></i> Ergonomi Berkebutuhan Khusus</li>
                                    <li class="list-row list-row-accent"><i class="fas fa-star me-2" style="color: var(--secondary-color);"></i> Perbaikan Metode Kerja</li>
                                    <li class="list-row list-row-accent"><i class="fas fa-star me-2" style="color: var(--secondary-color);"></i> Karakuri</li>
                                    <li class="list-row list-row-accent"><i class="fas fa-star me-2" style="color: var(--secondary-color);"></i> Aplikasi Ergonomi Industri</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== FACILITIES ===================== --}}
    <section class="py-5 bg-particles" id="facilities" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow">Fasilitas Kami</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Fasilitas & SOP</h2>
                <p class="section-subtitle mx-auto">Ruang dan peralatan yang mendukung praktikum, penelitian, dan kegiatan mahasiswa di LPSKE.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card-flat h-100 p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="icon-circle"><i class="fas fa-ruler-combined"></i></span>
                            <span class="badge-soft">Sistem Kerja</span>
                        </div>
                        <h5 class="fw-bold mb-2">Laboratorium</h5>
                        <p class="text-muted mb-3">Dilengkapi dengan peralatan pengukuran antropometri dan analisis postur kerja.</p>
                        <button type="button" class="btn btn-outline-brand w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#sopModal1">
                            <i class="fas fa-file-alt me-2"></i> Lihat SOP
                        </button>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="120">
                    <div class="card-flat h-100 p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="icon-circle"><i class="fas fa-desktop"></i></span>
                            <span class="badge-soft">Laboran</span>
                        </div>
                        <h5 class="fw-bold mb-2">Ruang Laboran</h5>
                        <p class="text-muted mb-3">Didalamnya terdapat ruang iklim dan ruang dosen.</p>
                        <button type="button" class="btn btn-outline-brand w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#sopModal2">
                            <i class="fas fa-file-alt me-2"></i> Lihat SOP
                        </button>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="240">
                    <div class="card-flat h-100 p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="icon-circle"><i class="fas fa-users"></i></span>
                            <span class="badge-soft">Diskusi</span>
                        </div>
                        <h5 class="fw-bold mb-2">Ruang Rapat</h5>
                        <p class="text-muted mb-3">Tempat diskusi dan presentasi untuk mahasiswa dan peneliti.</p>
                        <button type="button" class="btn btn-outline-brand w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#sopModal3">
                            <i class="fas fa-file-alt me-2"></i> Lihat SOP
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include SOP Modals -->
    @include('landing.sop_modals')

    {{-- ===================== PRODUK UNGGULAN ===================== --}}
    @include('partials.produk-unggulan')

    {{-- ===================== VR ERGONOMY LAB (UNGGULAN) ===================== --}}
    @include('partials.vr-ergonomy-highlight')

    {{-- ===================== ASISTEN LABORATORIUM ===================== --}}
    <section class="py-5 bg-particles" id="asisten" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end mb-5 gap-3" data-aos="fade-up">
                <div>
                    <span class="eyebrow">Tim Kami</span>
                    <h2 class="section-title mb-0" style="font-size: 2.1rem;">Asisten Laboratorium</h2>
                </div>
                <a href="{{ route('asisten-laboratorium') }}" class="btn btn-outline-brand">
                    <i class="fas fa-users me-2"></i> Lihat Semua
                </a>
            </div>
            <div class="row g-4">
                @forelse($asisten as $asistenItem)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                    <div class="card-flat h-100 p-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="icon-circle me-3"><i class="fas fa-user-graduate"></i></span>
                            <div>
                                <h6 class="fw-bold mb-0" style="color: var(--ink);">{{ $asistenItem->name }}</h6>
                                <small class="text-muted">Asisten LPSKE</small>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    @if($asistenItem->nim)
                                    <tr>
                                        <td class="text-muted ps-0" style="width: 28px;"><i class="fas fa-id-card"></i></td>
                                        <td class="text-muted small">NIM:</td>
                                        <td class="small">{{ $asistenItem->nim }}</td>
                                    </tr>
                                    @endif
                                    @if($asistenItem->angkatan)
                                    <tr>
                                        <td class="text-muted ps-0"><i class="fas fa-calendar-alt"></i></td>
                                        <td class="text-muted small">Angkatan:</td>
                                        <td class="small">{{ $asistenItem->angkatan }}</td>
                                    </tr>
                                    @endif
                                    @if($asistenItem->study_program)
                                    <tr>
                                        <td class="text-muted ps-0"><i class="fas fa-graduation-cap"></i></td>
                                        <td class="text-muted small">Program:</td>
                                        <td class="small">{{ $asistenItem->study_program }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
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

    {{-- ===================== FEATURED: PRESTASI & KEGIATAN ===================== --}}
    <section class="py-5 bg-particles" id="prestasi-kegiatan" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end mb-5 gap-3" data-aos="fade-up">
                <div>
                    <span class="eyebrow">Kabar Terbaru</span>
                    <h2 class="section-title mb-0" style="font-size: 2.1rem;">Prestasi & Kegiatan</h2>
                </div>
                <a href="{{ route('prestasi-kegiatan.index') }}" class="btn btn-outline-brand">
                    <i class="fas fa-list me-2"></i> Lihat Semua
                </a>
            </div>
            <div class="row g-4">
                @forelse($featuredItems as $item)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index, 5) * 80 }}">
                    <div class="card-flat h-100 overflow-hidden">
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
                        @else
                            <img src="{{ $item->gambar_url }}" class="w-100 img-thumb-accent" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge rounded-pill text-uppercase px-3 py-2" style="font-size: 0.75em; background: {{ $item->jenis === 'prestasi' ? 'var(--secondary-color)' : 'var(--primary-color)' }}; color: #fff;">
                                    <i class="fas {{ $item->jenis === 'prestasi' ? 'fa-trophy' : 'fa-bolt' }} me-1"></i>
                                    {{ ucfirst($item->jenis) }}
                                </span>
                                @if($item->is_featured)
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-star me-1"></i> Unggulan
                                    </span>
                                @endif
                            </div>
                            <h5 class="fw-bold mb-2">{{ $item->judul }}</h5>
                            @if($item->deskripsi)
                                <p class="text-muted mb-3">{{ Str::limit($item->deskripsi, 100) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2" style="border-top: 1px solid var(--hairline);">
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i>{{ $item->tanggal->format('d M Y') }}</small>
                                <a href="{{ route('prestasi-kegiatan.show', $item) }}" class="btn btn-sm btn-outline-brand px-3">Lihat Detail</a>
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
                    <h5 class="modal-title fw-bold" style="color: var(--primary-color);">Alumni {{ $i }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('images/gallery-' . $i . '.jpg') }}" class="img-fluid rounded-4 img-hero-accent" alt="Gallery {{ $i }}">
                </div>
            </div>
        </div>
    </div>
    @endfor

    {{-- ===================== KOLABORASI PROYEK / PARTNERS ===================== --}}
    <section class="py-5 position-relative band-deep section-py">
        <div class="container position-relative" style="z-index: 1;">
            <div class="text-center" data-aos="fade-up">
                <span class="eyebrow">Mitra &amp; Jaringan</span>
                <h3 class="fw-bold mb-3" style="font-size: 2rem;">Kolaborasi Proyek</h3>
                <p class="lead mb-5 opacity-90 mx-auto" style="max-width: 640px;">
                    Website LPSKE ini dikembangkan melalui kerja sama yang solid antara berbagai pihak yang berkontribusi dalam pengembangan sistem informasi laboratorium.
                </p>
            </div>

            @php
                $kolaboratorLogos = [
                    ['src' => 'images/smk2ska.png', 'alt' => 'SMK N 2 Surakarta'],
                    ['src' => 'images/enuma.jfif', 'alt' => 'Enuma Technology'],
                    ['src' => 'images/title_lpske.png', 'alt' => 'LPSKE'],
                    ['src' => 'images/mers.jfif', 'alt' => 'Mersiflab'],
                    ['src' => 'images/Ptik uns.png', 'alt' => 'PTIK UNS'],
                    ['src' => 'images/Smk6.png', 'alt' => 'SMK N 6 Surakarta'],
                    ['src' => 'images/Sportflux.png', 'alt' => 'Sportflux'],
                    ['src' => 'images/Brainova.png', 'alt' => 'Brainova'],
                ];
            @endphp

            <div class="logo-marquee mb-5" data-aos="fade-up" data-aos-delay="100">
                <div class="logo-track">
                    {{-- Logos are rendered twice back-to-back so the scroll loop is seamless --}}
                    @for ($rep = 0; $rep < 2; $rep++)
                        @foreach($kolaboratorLogos as $logo)
                            <div class="partner-avatar" aria-hidden="{{ $rep === 1 ? 'true' : 'false' }}">
                                <img src="{{ asset($logo['src']) }}" alt="Kolaborator {{ $logo['alt'] }}" loading="lazy">
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="150">
                <a href="{{ route('kolaborator') }}" class="btn btn-light btn-lg px-4 py-2 shadow-sm" style="border-radius: 50px;">
                    <i class="fas fa-eye me-2"></i> Lihat Selengkapnya
                </a>
            </div>
        </div>

        <!-- Decorative elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0; opacity: 0.08;">
            <div class="position-absolute" style="top: 20%; left: 10%; width: 100px; height: 100px; background: white; border-radius: 50%;"></div>
            <div class="position-absolute" style="top: 60%; right: 15%; width: 60px; height: 60px; background: white; border-radius: 50%;"></div>
            <div class="position-absolute" style="bottom: 20%; left: 20%; width: 80px; height: 80px; background: white; border-radius: 50%;"></div>
        </div>
    </section>

@endsection
