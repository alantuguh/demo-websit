{{--
    Video sorotan 10 detik di bawah header landing.

    Sumbernya montase dari enam video produk LPSKE yang sudah ada di
    public/videos — dirakit dengan ffmpeg: 6 klip x 2 detik, silang-pudar 0,4
    detik, tepat 10,000 detik, tanpa audio.

    Sengaja diberi bingkai (bukan menempel penuh ke tepi layar) supaya wave
    divider di dasar hero tetap mendarat di latar halaman seperti rancangan
    aslinya, tidak menimpa tepi atas video.
--}}
<section class="py-5 bg-particles" id="sorotan" style="padding-top: 4rem !important; padding-bottom: 4rem !important;">
    <div class="container">
        <div class="sorotan-frame" data-aos="fade-up">
            <video class="sorotan-video"
                   src="{{ asset('videos/lpske-sorotan.mp4') }}"
                   poster="{{ asset('images/products/lpske-sorotan.jpg') }}"
                   muted
                   loop
                   playsinline
                   preload="none"
                   tabindex="-1"
                   aria-label="Cuplikan produk dan kegiatan LPSKE"></video>
        </div>

        <p class="sorotan-caption" data-aos="fade-up" data-aos-delay="100">
            Sekilas karya LPSKE — simulator ergonomi, ErgoDrive, ErgoFit, Fumorive,
            Neuro Academy, dan SportFlux.
        </p>
    </div>
</section>

@push('styles')
<style>
    .sorotan-frame {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-lg);
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-rest), 0 0 0 1px var(--glass-edge);
        background: #0b1430;
        /* Sumbernya 16:9; di layar lebar dipangkas jadi pita sinematik. */
        aspect-ratio: 21 / 9;
    }

    .sorotan-frame video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Kilau tipis di tepi atas, menyambung garis cahaya navbar dan footer */
    .sorotan-frame::after {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.10), transparent 22%);
    }

    .sorotan-caption {
        margin: 1rem 0 0;
        text-align: center;
        font-size: 0.86rem;
        color: var(--muted);
    }

    /* Di layar sempit pita 21:9 jadi terlalu pipih untuk dilihat */
    @media (max-width: 767.98px) {
        .sorotan-frame {
            aspect-ratio: 16 / 9;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var video = document.querySelector('.sorotan-video');
        if (!video || !('IntersectionObserver' in window)) {
            return;
        }

        // preload="none": berkasnya baru diunduh saat play() dipanggil, dan
        // dihentikan begitu tergulir keluar layar supaya tidak terus men-decode.
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
        }, { threshold: 0.25 });

        observer.observe(video);
    });
</script>
@endpush
