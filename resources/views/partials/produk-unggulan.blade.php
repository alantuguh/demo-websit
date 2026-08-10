{{--
    ============================================================================
    Produk Unggulan LPSKE — slideshow kartu yang berjalan dari kiri ke kanan.
    ----------------------------------------------------------------------------
    Untuk menambah / mengubah produk, cukup sunting array $produkUnggulan di
    bawah ini. Tiap entri:

      nama      : judul kartu (wajib)
      deskripsi : 1-2 kalimat; kosongkan ('') kalau belum ada
      url       : alamat situs; kosongkan kalau belum ada (tombol disembunyikan)
      video     : nama file di public/videos tanpa ekstensi; '' kalau belum ada
      poster    : nama file di public/images/products tanpa ekstensi
      logo      : dipakai kalau tidak ada video, file di public/images
      ikon      : cadangan terakhir kalau tidak ada video maupun logo
      unggulan  : true -> diberi label penanda

    Video dikompres ke lebar 720px tanpa audio (semua diputar dalam keadaan
    mute), sehingga total muatan slideshow ini ~2,7 MB, bukan 21 MB seperti
    berkas aslinya.
    ============================================================================
--}}
@php
    $produkUnggulan = [
        [
            'nama' => 'Ergonomy Simulator Driving Lab',
            'deskripsi' => 'Simulator mengemudi yang dikembangkan sendiri oleh LPSKE sebagai sarana penelitian ergonomi dan perilaku pengemudi di laboratorium.',
            'url' => '',
            'video' => 'simulator-lab',
            'poster' => 'simulator-lab',
            'logo' => '',
            'ikon' => 'fa-car-side',
            'unggulan' => true,
        ],
        [
            'nama' => 'ErgoDrive',
            'deskripsi' => 'Inovasi driving simulator low-cost untuk kajian ergonomi berkendara.',
            'url' => 'https://ergodrive.ti-uns.com',
            'video' => 'ergodrive',
            'poster' => 'ergodrive',
            'logo' => '',
            'ikon' => 'fa-gauge-high',
            'unggulan' => false,
        ],
        [
            'nama' => 'ErgoFit',
            'deskripsi' => 'Sensor IMU nirkabel yang memantau postur kerja secara real-time dan menilai risikonya memakai metode RULA berbasis machine learning.',
            'url' => 'https://ergofit.ti-uns.com',
            'video' => 'ergofit',
            'poster' => 'ergofit',
            'logo' => '',
            'ikon' => 'fa-person-walking',
            'unggulan' => false,
        ],
        [
            'nama' => 'Neuro Academy',
            'deskripsi' => 'Platform pendidikan STEM yang menyatukan lab EEG/BCI interaktif, ensiklopedia biosignal, dan pembelajaran adaptif langsung dari peramban.',
            'url' => 'https://neuro-academy.web.app',
            'video' => 'neuro-academy',
            'poster' => 'neuro-academy',
            'logo' => '',
            'ikon' => 'fa-brain',
            'unggulan' => false,
        ],
        [
            'nama' => 'Fumorive',
            'deskripsi' => 'Simulasi berkendara yang mendeteksi kelelahan dini pada pengemudi jarak jauh. Memadukan pemantauan EEG real-time lewat headband Muse 2 dengan computer vision — PERCLOS, frekuensi kedipan, menguap, dan posisi kepala — hingga akurasi 98%, disertai peringatan bertingkat sebelum microsleep terjadi.',
            'url' => 'https://fumorive.vercel.app/',
            'video' => 'fumorive',
            'poster' => 'fumorive',
            'logo' => '',
            'ikon' => 'fa-microchip',
            'unggulan' => false,
        ],
        [
            'nama' => 'SportFlux',
            'deskripsi' => 'Startup sport tech yang mendiagnosis, menganalisis, dan mengevaluasi performa otot lewat aplikasi berbasis sensor EMG (Electromyography). Perangkatnya menampilkan level energi otot melalui indikator warna, ditopang aplikasi mobile untuk atlet, pelatih, serta konsultasi daring dengan fisioterapis.',
            'url' => 'https://sportflux.web.app',
            'video' => 'sportflux',
            'poster' => 'sportflux',
            'logo' => 'Sportflux.png',
            'ikon' => 'fa-stopwatch',
            'unggulan' => false,
        ],
        [
            'nama' => 'PosturGo',
            'deskripsi' => 'Sistem pemantauan postur kerja real-time berbasis sensor dan AI untuk meningkatkan ergonomi serta produktivitas di tempat kerja.',
            'url' => 'https://posturgo.ti-uns.com',
            'video' => '',
            'poster' => '',
            'logo' => '',
            'ikon' => 'fa-person-rays',
            'unggulan' => false,
        ],
        [
            'nama' => 'BrainNova',
            'deskripsi' => 'Platform neurotechnology berbasis analisis sinyal otak (EEG) yang dikembangkan tim mahasiswa UNS. Memadukan perangkat EEG Muse dengan Neuro-AI Signal Processing Engine untuk analisis real-time gelombang Delta, Theta, Alpha, dan Beta guna menopang kesehatan mental, pendidikan, serta keselamatan publik.',
            'url' => 'https://brainovahub.com',
            'video' => '',
            'poster' => '',
            'logo' => 'Brainova.png',
            'ikon' => 'fa-lightbulb',
            'unggulan' => false,
        ],
    ];
@endphp

<section class="py-5 bg-particles" id="produk" style="padding-top: 6rem !important; padding-bottom: 6rem !important;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="eyebrow"><i class="fas fa-rocket me-1"></i> Karya Kami</span>
            <h2 class="section-title text-center" style="font-size: 2.1rem;">Produk Unggulan</h2>
            <p class="section-subtitle mx-auto">
                Produk dan platform digital yang dikembangkan oleh LPSKE bersama mitra kolaborasi.
            </p>
        </div>
    </div>

    {{-- Marquee sengaja diletakkan di luar .container supaya kartu bisa mengalir
         sampai ke tepi layar. --}}
    <div class="product-marquee" data-aos="fade-up" data-aos-delay="100">
        <div class="product-track">
            {{-- Daftar dirender dua kali berturut-turut agar putarannya mulus.
                 Salinan kedua ditandai aria-hidden supaya pembaca layar tidak
                 membacakan produk yang sama dua kali. --}}
            @for ($rep = 0; $rep < 2; $rep++)
                @foreach ($produkUnggulan as $produk)
                    <article class="product-card"
                             @if ($rep === 1) aria-hidden="true" data-clone="true" @endif>
                        <div class="product-media">
                            @if ($produk['unggulan'])
                                <span class="product-flag">Unggulan Baru</span>
                            @endif

                            @if ($produk['video'])
                                <video
                                    src="{{ asset('videos/' . $produk['video'] . '.mp4') }}"
                                    @if ($produk['poster']) poster="{{ asset('images/products/' . $produk['poster'] . '.jpg') }}" @endif
                                    muted
                                    loop
                                    playsinline
                                    preload="none"
                                    tabindex="-1"
                                    aria-label="Cuplikan {{ $produk['nama'] }}"></video>
                            @elseif ($produk['logo'])
                                <div class="product-media-empty">
                                    <img src="{{ asset('images/' . $produk['logo']) }}"
                                         alt="Logo {{ $produk['nama'] }}" loading="lazy">
                                </div>
                            @else
                                <div class="product-media-empty">
                                    <i class="fas {{ $produk['ikon'] }}" aria-hidden="true"></i>
                                </div>
                            @endif
                        </div>

                        <div class="product-body">
                            <h3 class="product-title">{{ $produk['nama'] }}</h3>

                            @if ($produk['deskripsi'])
                                <p class="product-desc">{{ $produk['deskripsi'] }}</p>
                            @else
                                <p class="product-desc product-desc-empty">Deskripsi menyusul.</p>
                            @endif

                            @if ($produk['url'])
                                <a class="product-link"
                                   href="{{ $produk['url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   @if ($rep === 1) tabindex="-1" @endif>
                                    Kunjungi situs <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            @endfor
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var videos = document.querySelectorAll('.product-media video');
        if (!videos.length) {
            return;
        }

        // Video dimuat dengan preload="none", jadi berkasnya baru diunduh saat
        // play() dipanggil. Dengan hanya memutar kartu yang benar-benar terlihat,
        // pengunjung yang tidak menggulir sampai section ini tidak mengunduh
        // apa pun, dan paling banyak 3-4 video yang di-decode bersamaan.
        if (!('IntersectionObserver' in window)) {
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                var video = entry.target;
                if (entry.isIntersecting) {
                    if (video.paused) {
                        var attempt = video.play();
                        // Safari/iOS menolak autoplay dalam kondisi hemat daya —
                        // biarkan gagal diam-diam, poster tetap tampil.
                        if (attempt && typeof attempt.catch === 'function') {
                            attempt.catch(function () {});
                        }
                    }
                } else if (!video.paused) {
                    video.pause();
                }
            });
        }, { threshold: 0.35 });

        videos.forEach(function (video) {
            observer.observe(video);
        });
    });
</script>
@endpush
