<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sesi pemantauan Muse Lab (/muse-lab).
 *
 * Data mentah EEG tidak disimpan di server — terlalu besar dan bisa diekspor
 * CSV langsung dari browser. Yang disimpan hanya ringkasan sesi (rata-rata
 * band power, indeks ergonomi, distribusi kategori, statistik postur) untuk
 * arsip praktikum/penelitian di panel admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('muse_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('nama_subjek');

            // Aktivitas yang dikerjakan subjek selama sesi, mis. "mengetik",
            // "simulasi mengemudi", "istirahat" — konteks interpretasi.
            $table->string('aktivitas')->nullable();

            $table->string('perangkat')->nullable();
            $table->boolean('mode_demo')->default(false);

            $table->dateTime('mulai_pada');
            $table->unsignedInteger('durasi_detik');

            // Ringkasan metrik sesi; struktur dijaga aplikasi, bukan database.
            $table->json('ringkasan');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('muse_sessions');
    }
};
