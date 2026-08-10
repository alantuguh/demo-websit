{{--
    Segmen unggulan VR Ergonomy Lab di landing page.

    Sengaja memakai band gelap (.band-deep) agar berdiri terpisah dari section
    lain yang berlatar terang — ini satu-satunya segmen di landing yang mengarah
    ke halaman tersendiri, jadi memang diberi bobot visual paling besar.

    Daftar ruang dibaca langsung dari database (dibatasi 6) supaya segmen ini
    ikut berubah begitu ruang ditambah lewat panel admin, tanpa menyunting blade.
--}}
@php
    $vrRooms = \App\Models\VrRoom::active()
        ->orderBy('sort_order')
        ->take(6)
        ->get(['nama', 'slug', 'ikon']);

    $vrTotalModul = \App\Models\VrModule::active()->count();
@endphp

@if ($vrRooms->isNotEmpty())
    <section class="py-5 position-relative band-deep section-py" id="vr-ergonomy">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center g-5">

                <div class="col-lg-6" data-aos="fade-up">
                    <span class="eyebrow">
                        <i class="fas fa-vr-cardboard me-1"></i> Unggulan
                    </span>

                    <h2 class="fw-bold mb-3" style="font-size: 2.2rem; color: #fff;">
                        VR <span class="text-gradient">Ergonomy</span> Lab
                    </h2>

                    <p class="lead mb-4" style="max-width: 560px;">
                        Laboratorium ergonomi LPSKE dalam realitas virtual — {{ $vrRooms->count() }} ruang
                        tematik berisi {{ $vrTotalModul }} modul latihan, dari pengukuran antropometri
                        sampai simulasi berkendara. Praktikum tanpa antre alat, tanpa batas jam lab.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('vr-ergonomy.index') }}" class="btn btn-brand btn-lg px-4">
                            <i class="fas fa-vr-cardboard me-2"></i> Jelajahi VR Ergonomy Lab
                        </a>
                        <a href="{{ route('vr-ergonomy.index') }}#katalog" class="btn btn-outline-brand btn-lg px-4">
                            <i class="fas fa-cubes me-2"></i> Lihat Katalog
                        </a>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                    <div class="vr-highlight-visual">
                        @foreach ($vrRooms as $room)
                            <a href="{{ route('vr-ergonomy.room', $room->slug) }}"
                               class="vr-highlight-room text-decoration-none">
                                <i class="fas {{ $room->ikon }}" aria-hidden="true"></i>
                                <span>{{ $room->nama }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
@endif
