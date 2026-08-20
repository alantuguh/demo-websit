<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Produk yang dijual LPSKE lewat halaman /toko.
 *
 * Terpisah dari karya_labs (Katalog Produk & Karya) karena tabel itu berisi
 * portofolio, sedangkan tabel ini barang komersial: punya harga, daftar
 * kelengkapan paket, dan pesanan masuk di tabel product_orders.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');

            // URL halaman detail: /toko/{slug}
            $table->string('slug')->unique();

            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();

            // Rupiah utuh tanpa desimal (mis. 40000000 = Rp 40.000.000)
            $table->unsignedBigInteger('harga');

            // Daftar isi paket, mis. ["PC siap pakai", "Rig simulator", ...]
            $table->json('kelengkapan')->nullable();

            // Gambar utama + galeri tambahan; path relatif storage publik
            $table->string('gambar')->nullable();
            $table->json('galeri')->nullable();

            // null = dirakit sesuai pesanan (indent), angka = stok tersedia
            $table->unsignedInteger('stok')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
