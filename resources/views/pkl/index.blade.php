@extends('layout.app')

{{--
    Halaman promosi program PKL (Praktik Kerja Lapangan) untuk siswa SMK.

    Bukti yang ditampilkan nyata: siswa PKL angkatan sebelumnya tercatat di
    halaman Kolaborator (SMK N 2 Surakarta — situs ini salah satu hasil
    kerjanya), jadi halaman ini banyak menautkan ke sana alih-alih membuat
    klaim baru. Video promosi: public/videos/promosi-pkl.mp4 (H.264, hasil
    transcode dari dokum/PromosiPKL.mp4 yang aslinya HEVC).
--}}

@section('content')

    {{-- ===================== HERO ===================== --}}
    <section class="page-header-band page-hero" style="--hero-photo: url('{{ asset('images/lab.jpg') }}');">
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="eyebrow" data-aos="fade-up">
                        <i class="fas fa-briefcase me-1"></i> Program PKL untuk SMK
                    </span>
                    <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
                        PKL di <span class="text-gradient">LPSKE</span>:<br>
                        Magang di Laboratorium, Bukan di Belakang Meja Fotokopi
                    </h1>
                    <p class="lead mx-auto mx-lg-0" style="max-width: 620px;" data-aos="fade-up" data-aos-delay="200">
                        LPSKE membuka kesempatan Praktik Kerja Lapangan bagi siswa SMK.
                        Kamu ikut mengerjakan proyek yang benar-benar dipakai — website,
                        media promosi, sampai perangkat laboratorium VR — didampingi
                        asisten dan dosen laboratorium.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 mt-4"
                         data-aos="fade-up" data-aos-delay="300">
                        <a href="#video-pkl" class="btn btn-brand btn-lg px-4">
                            <i class="fas fa-play me-2"></i> Tonton Videonya
                        </a>
                        <a href="#alur" class="btn btn-outline-brand btn-lg px-4">
                            <i class="fas fa-route me-2"></i> Cara Mendaftar
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 mx-auto text-center">
                    <div class="hero3d-stage" data-aos="fade-left" data-aos-delay="150">
                        <span class="hero3d-orb o1"></span>
                        <span class="hero3d-orb o2"></span>
                        <div class="hero3d-tile tile-main g-primary" title="PKL"><i class="fas fa-briefcase"></i></div>
                        <div class="hero3d-tile tile-1 g-secondary" title="SMK"><i class="fas fa-school"></i></div>
                        <div class="hero3d-tile tile-2 g-accent" title="Proyek Nyata"><i class="fas fa-laptop-code"></i></div>
                        <div class="hero3d-tile tile-3 g-light" title="Bimbingan"><i class="fas fa-user-graduate"></i></div>
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

    {{-- ===================== VIDEO PROMOSI ===================== --}}
    <section class="py-5 bg-particles" id="video-pkl" style="padding-top: 4rem !important; padding-bottom: 4rem !important;">
        <div class="container">
            <div class="text-center mb-4" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-film me-1"></i> Video</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Seperti Apa PKL di LPSKE?</h2>
                <p class="section-subtitle mx-auto">
                    Dua menit melihat langsung suasana dan kegiatan siswa PKL di laboratorium.
                </p>
            </div>

            <div class="pkl-video-frame" data-aos="fade-up" data-aos-delay="100">
                {{-- Autoplay hanya diizinkan browser jika muted; kontrol tetap
                     dipasang supaya pengunjung bisa menyalakan suara narasi. --}}
                <video id="pkl-video"
                       src="{{ asset('videos/promosi-pkl.mp4') }}"
                       poster="{{ asset('images/promosi-pkl.jpg') }}"
                       controls
                       muted
                       loop
                       playsinline
                       preload="none"
                       aria-label="Video promosi program PKL LPSKE"></video>
            </div>
            <p class="text-center text-muted mt-3 mb-0" style="font-size: 0.85rem;" data-aos="fade-up">
                <i class="fas fa-volume-xmark me-1" aria-hidden="true"></i>
                Video diputar otomatis tanpa suara &mdash; klik ikon speaker untuk mendengar narasinya.
            </p>
        </div>
    </section>

    {{-- ===================== KENAPA DI LPSKE ===================== --}}
    <section class="py-5 bg-particles" id="kenapa" style="padding-top: 5rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-lightbulb me-1"></i> Kenapa LPSKE</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">PKL yang Benar-Benar Menambah Skill</h2>
                <p class="section-subtitle mx-auto">
                    Banyak tempat PKL hanya memberi tugas administratif. Di LPSKE, kamu
                    diperlakukan sebagai bagian dari tim laboratorium.
                </p>
            </div>

            <div class="row g-4">
                @php
                    $alasan = [
                        [
                            'ikon' => 'fa-diagram-project',
                            'judul' => 'Proyek Nyata',
                            'teks' => 'Website yang sedang kamu buka ini dikerjakan bersama siswa PKL. Hasil kerjamu dipakai sungguhan, bukan sekadar tugas latihan.',
                        ],
                        [
                            'ikon' => 'fa-user-graduate',
                            'judul' => 'Dibimbing Langsung',
                            'teks' => 'Asisten laboratorium mendampingi harian, dosen laboratorium mengarahkan. Kamu tidak dilepas sendirian menghadapi tugas.',
                        ],
                        [
                            'ikon' => 'fa-id-badge',
                            'judul' => 'Portofolio Tercatat',
                            'teks' => 'Nama dan karyamu tercantum di halaman Kolaborator situs ini — bukti portofolio yang bisa kamu tunjukkan saat melamar kerja atau kuliah.',
                        ],
                        [
                            'ikon' => 'fa-flask',
                            'judul' => 'Lingkungan Laboratorium Kampus',
                            'teks' => 'Bekerja di tengah fasilitas riset ergonomi: simulator berkendara, perangkat VR, dan peralatan pengukuran sistem kerja.',
                        ],
                    ];
                @endphp

                @foreach ($alasan as $i => $item)
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="card-flat h-100 p-4">
                            <span class="icon-circle mb-3"><i class="fas {{ $item['ikon'] }}"></i></span>
                            <h5 class="fw-bold mb-2">{{ $item['judul'] }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.92rem;">{{ $item['teks'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== BIDANG PENEMPATAN ===================== --}}
    <section class="py-5 bg-particles" id="bidang" style="padding-top: 2rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-sitemap me-1"></i> Bidang</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Apa yang Akan Kamu Kerjakan?</h2>
                <p class="section-subtitle mx-auto">
                    Penempatan disesuaikan dengan jurusanmu di SMK dan kebutuhan
                    laboratorium saat itu.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up">
                    <div class="card-flat h-100 p-4">
                        <span class="icon-circle mb-3"><i class="fas fa-code"></i></span>
                        <h5 class="fw-bold mb-1">Pengembangan Web &amp; Aplikasi</h5>
                        <p class="pkl-jurusan mb-3">Cocok untuk: PPLG / RPL</p>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Membangun fitur website laboratorium (Laravel &amp; panel admin)</span></div>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Merapikan tampilan dan pengalaman pengguna</span></div>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Ikut menggarap aplikasi pendukung praktikum</span></div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-flat h-100 p-4">
                        <span class="icon-circle mb-3"><i class="fas fa-photo-film"></i></span>
                        <h5 class="fw-bold mb-1">Media &amp; Dokumentasi</h5>
                        <p class="pkl-jurusan mb-3">Cocok untuk: DKV / Multimedia / Broadcasting</p>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Membuat video profil produk dan kegiatan laboratorium</span></div>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Mendesain materi publikasi dan konten media sosial</span></div>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Mendokumentasikan praktikum dan penelitian</span></div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-flat h-100 p-4">
                        <span class="icon-circle mb-3"><i class="fas fa-vr-cardboard"></i></span>
                        <h5 class="fw-bold mb-1">Teknologi Lab &amp; VR</h5>
                        <p class="pkl-jurusan mb-3">Cocok untuk: TJKT / Elektronika</p>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Membantu perawatan simulator dan perangkat VR</span></div>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Menyiapkan perangkat untuk sesi praktikum</span></div>
                        <div class="list-row list-row-accent"><span style="font-size: 0.9rem;">Mengelola jaringan dan komputer laboratorium</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== BUKTI: ALUMNI PKL ===================== --}}
    <section class="py-5 bg-particles" id="bukti" style="padding-top: 2rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="card-flat p-4 p-lg-5" data-aos="fade-up">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="eyebrow"><i class="fas fa-circle-check me-1"></i> Bukti Nyata</span>
                        <h3 class="fw-bold mb-3" style="font-size: 1.6rem;">Sudah Dibuktikan Angkatan Sebelumnya</h3>
                        <p class="text-muted mb-3" style="font-size: 0.95rem;">
                            Siswa PKL dari SMK Negeri 2 Surakarta ikut membangun website LPSKE
                            yang sedang kamu buka ini — nama mereka tercatat permanen di halaman
                            Kolaborator. LPSKE juga menjalin kerja sama dengan SMK Negeri 6 Surakarta.
                        </p>
                        <a href="{{ route('kolaborator') }}" class="product-link">
                            Lihat siswa PKL angkatan sebelumnya <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <div class="pkl-logo-box text-center">
                                <img src="{{ asset('images/smk2ska.png') }}" alt="Logo SMK Negeri 2 Surakarta">
                                <p>SMK N 2 Surakarta</p>
                            </div>
                            <div class="pkl-logo-box text-center">
                                <img src="{{ asset('images/Smk6.png') }}" alt="Logo SMK Negeri 6 Surakarta">
                                <p>SMK N 6 Surakarta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== ALUR PENDAFTARAN ===================== --}}
    <section class="py-5 bg-particles" id="alur" style="padding-top: 2rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-route me-1"></i> Alur</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Cara Mendaftar</h2>
                <p class="section-subtitle mx-auto">
                    Prosesnya sederhana — empat langkah dari sekolahmu sampai hari pertama di laboratorium.
                </p>
            </div>

            <div class="row g-4">
                @php
                    $langkah = [
                        [
                            'judul' => 'Siapkan Surat Pengantar',
                            'teks' => 'Minta surat pengantar PKL resmi dari sekolahmu, lengkap dengan periode PKL yang direncanakan.',
                        ],
                        [
                            'judul' => 'Hubungi LPSKE',
                            'teks' => 'Kirim surat pengantar beserta data diri dan jurusanmu melalui kontak di halaman beranda.',
                        ],
                        [
                            'judul' => 'Perkenalan & Penempatan',
                            'teks' => 'Kami mengobrol singkat denganmu untuk mengenal minat dan kemampuanmu, lalu menentukan bidang penempatan.',
                        ],
                        [
                            'judul' => 'Mulai PKL',
                            'teks' => 'Kamu bergabung dengan tim laboratorium. Durasi mengikuti ketentuan sekolah masing-masing.',
                        ],
                    ];
                @endphp

                @foreach ($langkah as $i => $step)
                    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="card-flat h-100 p-4 pkl-step">
                            <span class="pkl-step-num">{{ $i + 1 }}</span>
                            <h5 class="fw-bold mb-2 mt-3">{{ $step['judul'] }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.92rem;">{{ $step['teks'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== TANYA JAWAB ===================== --}}
    <section class="py-5 bg-particles" id="faq" style="padding-top: 2rem !important; padding-bottom: 6rem !important;">
        <div class="container" style="max-width: 860px;">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="eyebrow"><i class="fas fa-circle-question me-1"></i> Tanya Jawab</span>
                <h2 class="section-title text-center" style="font-size: 2.1rem;">Yang Sering Ditanyakan</h2>
            </div>

            @php
                $faq = [
                    [
                        'tanya' => 'Jurusan apa saja yang bisa mendaftar?',
                        'jawab' => 'Utamanya PPLG/RPL, DKV/Multimedia, Broadcasting, TJKT, dan Elektronika. Jurusan lain tetap boleh menghubungi — penempatan disesuaikan dengan kebutuhan laboratorium.',
                    ],
                    [
                        'tanya' => 'Berapa lama durasi PKL-nya?',
                        'jawab' => 'Durasi mengikuti ketentuan sekolah masing-masing (umumnya 3–6 bulan). Jadwal harian disepakati bersama pembimbing di awal program.',
                    ],
                    [
                        'tanya' => 'Apakah ada penilaian dan bukti selesai PKL?',
                        'jawab' => 'Ada. Pembimbing laboratorium mengisi penilaian yang diminta sekolahmu, dan namamu tercatat sebagai kolaborator di situs ini untuk karya yang kamu ikut kerjakan.',
                    ],
                    [
                        'tanya' => 'Saya belum jago coding/desain. Boleh ikut?',
                        'jawab' => 'Boleh. Yang paling penting kemauan belajar — tugas diberikan bertahap sesuai kemampuan, dan selalu ada asisten yang bisa ditanya.',
                    ],
                ];
            @endphp

            @foreach ($faq as $i => $item)
                <details class="pkl-faq card-flat" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
                    <summary>
                        <span>{{ $item['tanya'] }}</span>
                        <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </summary>
                    <p>{{ $item['jawab'] }}</p>
                </details>
            @endforeach
        </div>
    </section>

    {{-- ===================== AJAKAN ===================== --}}
    <section class="py-5 position-relative band-deep section-py">
        <div class="container position-relative text-center" style="z-index: 1;">
            <span class="eyebrow">Gabung</span>
            <h3 class="fw-bold mb-3" style="font-size: 2rem;">Siap PKL yang Berbeda?</h3>
            <p class="lead mb-4 mx-auto" style="max-width: 640px;">
                Ajukan sekolahmu sekarang — kuota penempatan tiap periode terbatas
                mengikuti kapasitas pembimbingan laboratorium.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('home') }}#contact" class="btn btn-brand btn-lg px-4">
                    <i class="fas fa-envelope me-2"></i> Hubungi LPSKE
                </a>
                <a href="{{ route('kolaborator') }}" class="btn btn-outline-brand btn-lg px-4">
                    <i class="fas fa-users me-2"></i> Lihat Alumni PKL
                </a>
            </div>
        </div>
    </section>

@endsection

@push('styles')
<style>
    /* ===== Bingkai video promosi (senada .sorotan-frame di beranda) ===== */
    .pkl-video-frame {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-lg);
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-rest), 0 0 0 1px var(--glass-edge);
        background: #0b1430;
        aspect-ratio: 16 / 9;
        max-width: 960px;
        margin: 0 auto;
    }

    .pkl-video-frame video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ===== Label jurusan pada kartu bidang ===== */
    .pkl-jurusan {
        font-family: var(--font-mono);
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--primary-color);
    }

    /* ===== Logo sekolah mitra ===== */
    .pkl-logo-box img {
        height: 84px;
        width: auto;
        object-fit: contain;
    }

    .pkl-logo-box p {
        margin: 0.6rem 0 0;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--muted);
    }

    /* ===== Nomor langkah pendaftaran ===== */
    .pkl-step { position: relative; }

    .pkl-step-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 14px;
        font-family: var(--font-mono);
        font-weight: 700;
        font-size: 1.05rem;
        color: #fff;
        background: linear-gradient(140deg, var(--primary-color), var(--primary-bright));
        box-shadow: 0 10px 22px rgba(47, 95, 224, 0.34);
    }

    /* ===== FAQ pakai <details> supaya tanpa JavaScript tambahan ===== */
    .pkl-faq {
        padding: 0;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .pkl-faq summary {
        list-style: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.1rem 1.4rem;
        font-weight: 600;
        color: var(--ink);
    }

    .pkl-faq summary::-webkit-details-marker { display: none; }

    .pkl-faq summary i {
        color: var(--primary-color);
        transition: transform 0.25s ease;
        flex-shrink: 0;
    }

    .pkl-faq[open] summary i { transform: rotate(180deg); }

    .pkl-faq p {
        margin: 0;
        padding: 0 1.4rem 1.2rem;
        font-size: 0.92rem;
        color: var(--muted);
    }
</style>
@endpush

@push('scripts')
<script>
    // Autoplay video promosi saat kartunya terlihat, jeda saat tergulir keluar
    // (pola yang sama dengan video sorotan di beranda). preload="none":
    // berkas baru diunduh saat play() pertama dipanggil.
    document.addEventListener('DOMContentLoaded', function () {
        var video = document.getElementById('pkl-video');
        if (!video) return;

        if (!('IntersectionObserver' in window)) {
            video.play().catch(function () {});
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    if (entry.target.paused) {
                        var attempt = entry.target.play();
                        if (attempt && typeof attempt.catch === 'function') {
                            attempt.catch(function () {});
                        }
                    }
                } else if (!entry.target.paused) {
                    entry.target.pause();
                }
            });
        }, { threshold: 0.35 });

        observer.observe(video);
    });
</script>
@endpush
