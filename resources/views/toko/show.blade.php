@extends('layout.app')

{{-- Halaman detail satu produk toko + form pemesanan. --}}

@section('content')

    {{-- ===================== HERO RINGKAS ===================== --}}
    <section class="page-hero" style="padding: 100px 0 60px;">
        <div class="container">
            <div class="text-center mx-auto" style="max-width: 820px;">
                <a href="{{ route('toko.index') }}" class="toko-back mb-3" data-aos="fade-up">
                    <i class="fas fa-arrow-left me-2" aria-hidden="true"></i> Toko LPSKE
                </a>
                @if ($product->kategori)
                    <span class="eyebrow d-block" data-aos="fade-up" data-aos-delay="50">
                        <i class="fas fa-tag me-1"></i> {{ $product->kategori }}
                    </span>
                @endif
                <h1 class="fw-bold mb-2" style="font-size: 2rem; letter-spacing: -0.5px;" data-aos="fade-up" data-aos-delay="100">
                    {{ $product->nama }}
                </h1>
                <p class="toko-hero-harga mb-0" data-aos="fade-up" data-aos-delay="150">{{ $product->harga_rupiah }}</p>
            </div>
        </div>
    </section>

    {{-- ===================== DETAIL ===================== --}}
    <section class="py-5 bg-particles" style="padding-top: 4rem !important; padding-bottom: 6rem !important;">
        <div class="container">

            @if (session('pesan_sukses'))
                <div class="toko-alert mb-4" role="alert" data-aos="fade-up">
                    <i class="fas fa-circle-check me-2" aria-hidden="true"></i>{{ session('pesan_sukses') }}
                </div>
            @endif

            <div class="row g-5">
                {{-- Gambar --}}
                <div class="col-lg-7" data-aos="fade-up">
                    <div class="toko-galeri-utama card-flat">
                        @if ($product->gambar)
                            <img id="galeri-utama" src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}">
                        @else
                            <span class="toko-galeri-kosong"><i class="fas fa-box-open"></i></span>
                        @endif
                    </div>

                    @php
                        $semuaFoto = array_values(array_filter(array_merge(
                            [$product->gambar],
                            $product->galeri ?? []
                        )));
                    @endphp

                    @if (count($semuaFoto) > 1)
                        <div class="d-flex gap-3 mt-3 flex-wrap">
                            @foreach ($semuaFoto as $foto)
                                <button type="button" class="toko-thumb"
                                        onclick="document.getElementById('galeri-utama').src = this.querySelector('img').src;">
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto {{ $product->nama }}" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @if ($product->deskripsi)
                        <div class="mt-4">
                            <span class="eyebrow"><i class="fas fa-align-left me-1"></i> Deskripsi</span>
                            <p class="text-muted mt-2" style="font-size: 0.95rem; line-height: 1.8;">{{ $product->deskripsi }}</p>
                        </div>
                    @endif
                </div>

                {{-- Ringkasan + kelengkapan --}}
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-flat p-4 mb-4">
                        <p class="toko-harga-besar mb-1">{{ $product->harga_rupiah }}</p>
                        <p class="toko-card-stok mb-4">
                            <i class="fas {{ is_null($product->stok) ? 'fa-screwdriver-wrench' : 'fa-cubes' }} me-1" aria-hidden="true"></i>
                            {{ is_null($product->stok) ? 'Dirakit sesuai pesanan — hubungi kami untuk estimasi waktu' : ($product->stok > 0 ? 'Stok tersedia: ' . $product->stok . ' unit' : 'Stok sedang habis') }}
                        </p>

                        @if (!empty($product->kelengkapan))
                            <h6 class="fw-bold mb-2" style="font-size: 0.92rem;">Termasuk dalam paket:</h6>
                            @foreach ($product->kelengkapan as $item)
                                <div class="list-row list-row-accent">
                                    <i class="fas fa-check me-2" style="color: var(--secondary-color);" aria-hidden="true"></i>
                                    <span style="font-size: 0.9rem;">{{ $item }}</span>
                                </div>
                            @endforeach
                        @endif

                        <div class="d-grid gap-2 mt-4">
                            <a href="#form-pesan" class="btn btn-brand btn-lg">
                                <i class="fas fa-cart-shopping me-2"></i> Pesan Sekarang
                            </a>
                            @if ($whatsapp)
                                <a class="btn btn-outline-brand"
                                   target="_blank" rel="noopener noreferrer"
                                   href="https://wa.me/{{ $whatsapp }}?text={{ urlencode('Halo LPSKE, saya tertarik dengan produk "' . $product->nama . '" (' . route('toko.show', $product) . '). Boleh minta info lebih lanjut?') }}">
                                    <i class="fab fa-whatsapp me-2"></i> Tanya via WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Form pesanan --}}
                    <div class="card-flat p-4" id="form-pesan">
                        <span class="eyebrow"><i class="fas fa-file-signature me-1"></i> Form Pesanan</span>
                        <h5 class="fw-bold mb-1 mt-1">Pesan {{ $product->nama }}</h5>
                        <p class="text-muted mb-3" style="font-size: 0.85rem;">
                            Tanpa pembayaran di muka — tim LPSKE akan menghubungi Anda untuk
                            konfirmasi, penawaran resmi, dan cara pembayaran.
                        </p>

                        @if ($errors->any())
                            <div class="toko-alert toko-alert-error mb-3" role="alert">
                                <i class="fas fa-triangle-exclamation me-2" aria-hidden="true"></i>{{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('toko.pesan', $product) }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="toko-label" for="nama_pemesan">Nama Lengkap *</label>
                                    <input class="form-control toko-input" id="nama_pemesan" name="nama_pemesan"
                                           value="{{ old('nama_pemesan') }}" required maxlength="255">
                                </div>
                                <div class="col-md-6">
                                    <label class="toko-label" for="telepon">Telepon / WhatsApp *</label>
                                    <input class="form-control toko-input" id="telepon" name="telepon"
                                           value="{{ old('telepon') }}" required maxlength="30" inputmode="tel">
                                </div>
                                <div class="col-md-6">
                                    <label class="toko-label" for="email">Email</label>
                                    <input class="form-control toko-input" type="email" id="email" name="email"
                                           value="{{ old('email') }}" maxlength="255">
                                </div>
                                <div class="col-md-8">
                                    <label class="toko-label" for="instansi">Instansi / Perusahaan</label>
                                    <input class="form-control toko-input" id="instansi" name="instansi"
                                           value="{{ old('instansi') }}" maxlength="255">
                                </div>
                                <div class="col-md-4">
                                    <label class="toko-label" for="jumlah">Jumlah *</label>
                                    <input class="form-control toko-input" type="number" id="jumlah" name="jumlah"
                                           value="{{ old('jumlah', 1) }}" min="1" max="100" required>
                                </div>
                                <div class="col-12">
                                    <label class="toko-label" for="alamat">Alamat Pengiriman / Instalasi</label>
                                    <textarea class="form-control toko-input" id="alamat" name="alamat"
                                              rows="2" maxlength="1000">{{ old('alamat') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="toko-label" for="catatan">Catatan / Pertanyaan</label>
                                    <textarea class="form-control toko-input" id="catatan" name="catatan"
                                              rows="3" maxlength="2000">{{ old('catatan') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-brand btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i> Kirim Pesanan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== PRODUK LAIN ===================== --}}
    @if ($lainnya->isNotEmpty())
        <section class="py-5 bg-particles" style="padding-top: 2rem !important; padding-bottom: 6rem !important;">
            <div class="container">
                <div class="text-center mb-4" data-aos="fade-up">
                    <span class="eyebrow"><i class="fas fa-store me-1"></i> Lainnya</span>
                    <h2 class="section-title text-center" style="font-size: 1.7rem;">Produk Lain</h2>
                </div>
                <div class="row g-4">
                    @foreach ($lainnya as $i => $lain)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                            <a href="{{ route('toko.show', $lain) }}" class="card-flat h-100 p-4 d-block text-decoration-none">
                                <h5 class="fw-bold mb-1" style="color: var(--ink); font-size: 1rem;">{{ $lain->nama }}</h5>
                                <p class="toko-card-harga mb-2">{{ $lain->harga_rupiah }}</p>
                                <span class="product-link">Lihat detail <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('styles')
<style>
    .toko-back {
        display: inline-flex;
        align-items: center;
        font-size: 0.86rem;
        font-weight: 600;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.85);
        transition: color 0.2s ease;
    }
    .toko-back:hover { color: #a5f3fc; }

    .toko-hero-harga {
        font-size: 1.5rem;
        font-weight: 700;
        color: #a5f3fc;
    }

    .toko-harga-besar {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .toko-card-harga {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .toko-card-stok { font-size: 0.85rem; color: var(--muted); }

    .toko-galeri-utama {
        overflow: hidden;
        padding: 0;
        aspect-ratio: 16 / 9;
        background: #0b1430;
    }
    .toko-galeri-utama img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .toko-galeri-kosong {
        display: flex; align-items: center; justify-content: center;
        height: 100%; font-size: 2.4rem; color: rgba(255, 255, 255, 0.4);
    }

    .toko-thumb {
        width: 92px; height: 60px;
        padding: 0; border: 2px solid var(--glass-border);
        border-radius: 10px; overflow: hidden;
        background: #0b1430; cursor: pointer;
        transition: border-color 0.2s ease;
    }
    .toko-thumb:hover { border-color: var(--primary-color); }
    .toko-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .toko-label {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        margin-bottom: 0.3rem;
        color: var(--ink);
    }

    .toko-input {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 10px;
        font-size: 0.9rem;
    }
    .toko-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(47, 95, 224, 0.15);
    }

    .toko-alert {
        padding: 0.9rem 1.2rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        color: #14532d;
        background: rgba(34, 197, 94, 0.14);
        border: 1px solid rgba(34, 197, 94, 0.4);
    }

    .toko-alert-error {
        color: #7f1d1d;
        background: rgba(239, 68, 68, 0.12);
        border-color: rgba(239, 68, 68, 0.4);
    }
</style>
@endpush
