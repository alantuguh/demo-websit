<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proyek_laboratorium', function (Blueprint $table) {
            $table->id();
            $table->string('judul_proyek');

            // Program/kategori proyek: Wibawa, Jarpak, Semesta, DIKTI, Kerja Sama UNS
            $table->enum('kategori', ['wibawa', 'jarpak', 'semesta', 'dikti', 'kerjasama_uns']);

            $table->text('deskripsi')->nullable();
            $table->year('tahun');

            // Mitra/instansi terkait proyek (mis. Kemendikbudristek, UNS, dsb.)
            $table->string('mitra')->nullable();

            // Status pelaksanaan proyek
            $table->enum('status', ['berjalan', 'selesai'])->default('berjalan');

            // Media & tautan terkait
            $table->string('gambar')->nullable();
            $table->string('link_terkait')->nullable();

            // Fitur unggulan & status tampil
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            // Pengurutan tampilan
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyek_laboratorium');
    }
};
