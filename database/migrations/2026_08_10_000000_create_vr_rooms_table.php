<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ruang-ruang di dalam VR Ergonomy Lab.
 *
 * Setiap ruang mewakili satu tema praktikum ergonomi (antropometri, postur,
 * lingkungan kerja, dst.) dan menampung sejumlah modul VR di tabel vr_modules.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vr_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nama');

            // Dipakai sebagai URL halaman ruang: /vr-ergonomy/{slug}
            $table->string('slug')->unique();

            // Kalimat pendek pada kartu ruang, mis. "Pengukuran dimensi tubuh"
            $table->string('tema')->nullable();

            $table->text('deskripsi')->nullable();

            // Daftar capaian pembelajaran; disimpan sebagai JSON agar jumlah
            // butirnya bebas tanpa perlu tabel terpisah.
            $table->json('capaian')->nullable();

            // Kelas ikon Font Awesome, mis. "fa-ruler-combined"
            $table->string('ikon')->default('fa-vr-cardboard');

            // Warna aksen kartu ruang (hex), dipakai untuk gradien di halaman publik
            $table->string('warna', 7)->default('#2f5fe0');

            $table->string('gambar')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vr_rooms');
    }
};
