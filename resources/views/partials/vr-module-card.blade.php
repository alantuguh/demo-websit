{{--
    Kartu satu modul VR. Dipakai di halaman katalog (/vr-ergonomy) maupun di
    halaman ruang (/vr-ergonomy/{slug}).

    Variabel:
      $modul          — instance App\Models\VrModule (wajib)
      $tampilkanRuang — true untuk menampilkan nama ruang; di halaman ruang
                        nilainya false karena konteksnya sudah jelas.
--}}
@php
    $tampilkanRuang = $tampilkanRuang ?? false;
    $statusLabel = \App\Models\VrModule::statusOptions()[$modul->status] ?? $modul->status;
    $levelLabel = \App\Models\VrModule::levelOptions()[$modul->level] ?? $modul->level;
@endphp

<article class="card-flat h-100 p-4 d-flex flex-column">
    <div class="d-flex align-items-start justify-content-between gap-2 mb-3">
        <span class="vr-status vr-status-{{ $modul->status }}">{{ $statusLabel }}</span>
        <span class="badge-soft">{{ $levelLabel }}</span>
    </div>

    <h5 class="fw-bold mb-2" style="font-size: 1.02rem;">{{ $modul->judul }}</h5>

    @if ($tampilkanRuang && $modul->room)
        <a href="{{ route('vr-ergonomy.room', $modul->room) }}"
           class="vr-module-room text-decoration-none mb-2">
            <i class="fas {{ $modul->room->ikon }} me-1" aria-hidden="true"></i>{{ $modul->room->nama }}
        </a>
    @endif

    @if ($modul->deskripsi)
        <p class="text-muted mb-3" style="font-size: 0.9rem;">{{ $modul->deskripsi }}</p>
    @endif

    <div class="mt-auto pt-2" style="border-top: 1px solid var(--hairline);">
        <div class="d-flex flex-wrap gap-3 pt-2" style="font-size: 0.82rem; color: var(--muted);">
            @if ($modul->durasi_menit)
                <span><i class="far fa-clock me-1" aria-hidden="true"></i>{{ $modul->durasi_menit }} menit</span>
            @endif
            @if ($modul->perangkat)
                <span><i class="fas fa-headset me-1" aria-hidden="true"></i>{{ $modul->perangkat }}</span>
            @endif
        </div>

        @if ($modul->link_demo)
            <a href="{{ $modul->link_demo }}" target="_blank" rel="noopener noreferrer"
               class="product-link mt-3">
                Coba modul <i class="fas fa-arrow-right" aria-hidden="true"></i>
            </a>
        @endif
    </div>
</article>
