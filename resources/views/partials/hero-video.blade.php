{{--
    Video latar samar untuk band hero.

    Diletakkan sebagai anak pertama di dalam <section class="page-hero"> —
    gayanya (posisi, opasitas, peredup) ada di layout/app.blade.php pada blok
    ".page-hero-media", karena z-index-nya harus menimpa aturan `.page-hero > *`.

    Sumbernya montase 10 detik dari enam video produk LPSKE. Murni dekoratif,
    jadi ditandai aria-hidden dan tidak bisa menerima fokus.
--}}
<div class="page-hero-media" aria-hidden="true">
    <video class="page-hero-video"
           src="{{ asset('videos/lpske-sorotan.mp4') }}"
           poster="{{ asset('images/products/lpske-sorotan.jpg') }}"
           muted
           loop
           playsinline
           preload="none"
           tabindex="-1"></video>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var video = document.querySelector('.page-hero-video');
        if (!video) {
            return;
        }

        // Hormati preferensi hemat gerak: CSS sudah menyembunyikan lapisannya,
        // jadi jangan sampai berkasnya tetap diunduh diam-diam.
        var hematGerak = window.matchMedia('(prefers-reduced-motion: reduce)');
        if (hematGerak.matches) {
            return;
        }

        var mainkan = function () {
            var attempt = video.play();
            // Safari/iOS menolak autoplay saat mode hemat daya — biarkan gagal
            // diam-diam; foto lab di belakangnya tetap tampil seperti biasa.
            if (attempt && typeof attempt.catch === 'function') {
                attempt.catch(function () {});
            }
        };

        // preload="none": berkas baru diunduh saat play() dipanggil. Hero ada di
        // paling atas halaman, tapi observer tetap dipakai supaya video berhenti
        // di-decode begitu pengunjung menggulir melewatinya.
        if (!('IntersectionObserver' in window)) {
            mainkan();
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    if (entry.target.paused) {
                        mainkan();
                    }
                } else if (!entry.target.paused) {
                    entry.target.pause();
                }
            });
        }, { threshold: 0.15 });

        observer.observe(video);
    });
</script>
@endpush
