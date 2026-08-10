<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Katalog modul (skenario latihan) VR Ergonomy Lab.
 *
 * Satu modul selalu berada di dalam satu ruang. Saat ruang dihapus, modul di
 * dalamnya ikut terhapus supaya tidak ada modul yatim yang tetap tampil di
 * halaman katalog.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vr_modules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vr_room_id')
                ->constrained('vr_rooms')
                ->cascadeOnDelete();

            $table->string('judul');
            $table->text('deskripsi')->nullable();

            // Tingkat kesulitan skenario
            $table->enum('level', ['dasar', 'menengah', 'lanjut'])->default('dasar');

            // Status ketersediaan — katalog dirilis lebih dulu, isi produk
            // sesungguhnya menyusul, jadi mayoritas awalnya 'rencana'.
            $table->enum('status', ['tersedia', 'pengembangan', 'rencana'])->default('rencana');

            $table->unsignedSmallInteger('durasi_menit')->nullable();

            // Perangkat yang dibutuhkan, mis. "VR Headset", "Desktop"
            $table->string('perangkat')->nullable();

            $table->string('gambar')->nullable();
            $table->string('video_url')->nullable();

            // Diisi bila modul sudah bisa dijalankan/diunduh
            $table->string('link_demo')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vr_modules');
    }
};
