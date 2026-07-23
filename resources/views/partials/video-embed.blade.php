{{--
    Partial: Media thumbnail dengan "video facade"
    ------------------------------------------------
    Kenapa ini ada: menampilkan <iframe> penuh untuk SETIAP kartu video di sebuah
    grid itu berat (tiap iframe = 1 halaman YouTube penuh dimuat sekaligus, bahkan
    yang belum dilihat user). Partial ini menampilkan thumbnail ringan dengan
    tombol play di atasnya dulu — iframe video sesungguhnya baru dibuat saat
    kartu itu diklik. Video tetap jadi elemen visual utama (bukan cuma gambar
    statis biasa), tapi halaman jadi jauh lebih ringan & cepat dimuat.

    Wajib: sertakan komponen ini hanya di halaman yang sudah memuat
    layout.app (butuh CSS ".video-facade" & script listener globalnya).

    Parameter:
    - title           (string)      judul/alt text untuk aksesibilitas
    - videoUrl        (string|null) URL embed video. Null/kosong = bukan video.
    - imgUrl          (string|null) URL gambar fallback kalau videoUrl kosong.
    - height          (string)      tinggi container saat fixedHeight true. Default '200px'.
    - fixedHeight     (bool)        true = paksa tinggi tetap + object-fit cover
                                     (cocok untuk kartu grid). false = biarkan gambar
                                     mengikuti rasio aslinya (cocok untuk hero halaman detail).
                                     Diabaikan kalau maxHeight diisi. Default true.
    - maxHeight       (string|null) cap tinggi maksimum + object-fit cover, tapi gambar
                                     pendek/lebar tetap tampil natural (tidak dipaksa crop
                                     kalau belum menyentuh batas). Cocok untuk hero gambar
                                     di halaman detail yang rasio aslinya bervariasi.
                                     Kalau diisi, mengalahkan fixedHeight.
    - imgClass        (string)      class tambahan untuk <img> fallback.
                                     Default 'w-100 img-thumb-accent'.
    - wrapperClass    (string)      class tambahan untuk wrapper video (mis. 'mb-4').
    - showPlaceholder (bool)        tampilkan ikon placeholder kalau videoUrl & imgUrl
                                     dua-duanya kosong. Default true.

    Contoh pemakaian (kartu grid):
    @include('partials.video-embed', [
        'title'    => $item->judul,
        'videoUrl' => $item->is_video ? $item->video_url : null,
        'imgUrl'   => $item->gambar ? $item->gambar_url : null,
    ])

    Contoh pemakaian (hero halaman detail, tanpa placeholder & tanpa tinggi tetap):
    @include('partials.video-embed', [
        'title'          => $prestasiKegiatan->judul,
        'videoUrl'       => $prestasiKegiatan->is_video ? $prestasiKegiatan->video_url : null,
        'imgUrl'         => $prestasiKegiatan->gambar ? $prestasiKegiatan->gambar_url : null,
        'fixedHeight'    => false,
        'imgClass'       => 'img-fluid img-thumb-accent rounded-3 mb-4',
        'wrapperClass'   => 'mb-4',
        'showPlaceholder'=> false,
    ])

    Contoh pemakaian (hero dengan cap tinggi maksimum, mis. katalog karya):
    @include('partials.video-embed', [
        'title'          => $karyaLab->nama_karya,
        'imgUrl'         => $karyaLab->file_gambar_url,
        'maxHeight'      => '420px',
        'imgClass'       => 'img-fluid img-thumb-accent rounded mb-4 w-100',
        'showPlaceholder'=> false,
    ])
--}}
@php
    $__fixedHeight = $fixedHeight ?? true;
    $__height = $height ?? '200px';
    $__maxHeight = $maxHeight ?? null;
    $__imgClass = $imgClass ?? 'w-100 img-thumb-accent';
    $__wrapperClass = trim('ratio ratio-16x9 ' . ($wrapperClass ?? ''));
    $__showPlaceholder = $showPlaceholder ?? true;

    $__ytId = null;
    if (!empty($videoUrl) && preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|watch\?v=|v\/))([A-Za-z0-9_-]{11})/', $videoUrl, $__ytMatch)) {
        $__ytId = $__ytMatch[1];
    }
    // Thumbnail YouTube kalau bisa dideteksi, kalau tidak pakai gambar yang dikirim (kalau ada)
    $__poster = $__ytId ? "https://img.youtube.com/vi/{$__ytId}/hqdefault.jpg" : ($imgUrl ?? null);
@endphp

@if(!empty($videoUrl))
    <div class="video-facade {{ $__wrapperClass }}">
        <button type="button"
                class="video-facade__trigger"
                data-embed-src="{{ $videoUrl }}"
                data-embed-title="{{ $title ?? 'Video' }}"
                aria-label="Putar video: {{ $title ?? 'Video' }}"
                @if($__poster) style="background-image: url('{{ $__poster }}');" @endif>
            <span class="video-facade__badge"><i class="fas fa-video me-1"></i> Video</span>
            <span class="video-facade__play"><i class="fas fa-play"></i></span>
        </button>
    </div>
@elseif(!empty($imgUrl))
    @if(!empty($__maxHeight))
        <img src="{{ $imgUrl }}" class="{{ $__imgClass }}" alt="{{ $title ?? '' }}" style="max-height: {{ $__maxHeight }}; object-fit: cover;">
    @elseif($__fixedHeight)
        <img src="{{ $imgUrl }}" class="{{ $__imgClass }}" alt="{{ $title ?? '' }}" style="height: {{ $__height }}; object-fit: cover;">
    @else
        <img src="{{ $imgUrl }}" class="{{ $__imgClass }}" alt="{{ $title ?? '' }}">
    @endif
@elseif($__showPlaceholder)
    <div class="bg-light text-center py-5">
        <i class="fas fa-image fa-4x text-muted"></i>
    </div>
@endif
