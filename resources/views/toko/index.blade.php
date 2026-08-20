@extends('layout.app')

{{-- Katalog Toko LPSKE. Produk dikelola dari panel admin (Toko — Produk). --}}

@section('content')

    {{-- ===================== HERO ===================== --}}
    <section class="page-header-band page-hero" style="--hero-photo: url('{{ asset('images/lab.jpg') }}');">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="eyebrow" data-aos="fade-up"><i class="fas fa-store me-1"></i> Toko LPSKE</span>
                    <h1 class="display-5 fw-bold mb-3" style="letter-spacing: -1px;" data-aos="fade-up" data-aos-delay="100">
                        Produk <span class="text-gradient">Siap Pakai</span> dari Laboratorium
                    </h1>
                    <p class="lead mx-auto" style="max-width: 640px;" data-aos="fade-up" data-aos-delay="200">
                        Perangkat hasil pengembangan LPSKE yang bisa dipesan untuk institusi,
                        industri, maupun laboratorium lain — dirakit, dikalibrasi, dan
                        didampingi instalasinya oleh tim kami.
                    </p>
                </div>
                <div class="wave-divider-bottom">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                        <path d="M321.45,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C79.44,114.28,154.58,109.11,218.4,92.83c31.11-7.92,61.85-18.7,92.93-29.21Z" fill="rgba(239, 243, 252, 0.94)"></path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== DAFTAR PRODUK ===================== --}}
    <section class="py-5 bg-particles" style="padding-top: 4rem !important; padding-bottom: 6rem !important;">
        <div class="container">
            @if ($products->isEmpty())
                <div class="card-flat p-5 text-center" data-aos="fade-up">
                    <p class="text-muted mb-0">Belum ada produk yang dijual saat ini.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($products as $i => $product)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                            <a href="{{ route('toko.show', $product) }}" class="toko-card card-flat h-100 d-block text-decoration-none">
                                <div class="toko-card-media">
                                    @if ($product->gambar)
                                        <img src="{{ asset('storage/' . $product->gambar) }}"
                                             alt="{{ $product->nama }}" loading="lazy">
                                    @else
                                        <span class="toko-card-media-empty"><i class="fas fa-box-open"></i></span>
                                    @endif
                                    @if ($product->is_featured)
                                        <span class="toko-flag">Unggulan</span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    @if ($product->kategori)
                                        <span class="badge-soft mb-2 d-inline-block">{{ $product->kategori }}</span>
                                    @endif
                                    <h3 class="toko-card-title">{{ $product->nama }}</h3>
                                    <p class="toko-card-harga mb-1">{{ $product->harga_rupiah }}</p>
                                    <p class="toko-card-stok mb-3">
                                        {{ is_null($product->stok) ? 'Dirakit sesuai pesanan' : ($product->stok > 0 ? 'Stok: ' . $product->stok : 'Stok habis') }}
                                    </p>
                                    <span class="product-link">Lihat detail &amp; pesan <i class="fas fa-arrow-right" aria-hidden="true"></i></span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Cara pembelian --}}
            <div class="row g-4 mt-4">
                @php
                    $langkahBeli = [
                        ['ikon' => 'fa-file-signature', 'judul' => '1. Kirim Pesanan', 'teks' => 'Isi form pesanan di halaman produk — tanpa pembayaran di muka.'],
                        ['ikon' => 'fa-phone-volume', 'judul' => '2. Kami Hubungi', 'teks' => 'Tim LPSKE menghubungi Anda untuk konfirmasi kebutuhan, penawaran resmi, dan cara pembayaran.'],
                        ['ikon' => 'fa-truck-ramp-box', 'judul' => '3. Rakit & Instalasi', 'teks' => 'Perangkat dirakit, dikalibrasi, dikirim, dan dipasang dengan pendampingan tim kami.'],
                    ];
                @endphp
                @foreach ($langkahBeli as $i => $langkah)
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="card-flat h-100 p-4 text-center">
                            <span class="icon-circle mb-3 mx-auto"><i class="fas {{ $langkah['ikon'] }}"></i></span>
                            <h5 class="fw-bold mb-2" style="font-size: 1.02rem;">{{ $langkah['judul'] }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ $langkah['teks'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('styles')
<style>
    .toko-card { overflow: hidden; padding: 0; }

    .toko-card-media {
        position: relative;
        aspect-ratio: 16 / 9;
        background: #0b1430;
        overflow: hidden;
    }

    .toko-card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }

    .toko-card:hover .toko-card-media img { transform: scale(1.04); }

    .toko-card-media-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        font-size: 2.2rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .toko-flag {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 0.3rem 0.75rem;
        border-radius: var(--radius-pill);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #fff;
        background: linear-gradient(100deg, var(--primary-color), var(--primary-bright));
    }

    .toko-card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 0.5rem;
    }

    .toko-card-harga {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .toko-card-stok {
        font-size: 0.82rem;
        color: var(--muted);
    }
</style>
@endpush
