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
        Schema::create('karya_lab', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karya');
            $table->enum('kategori', ['penelitian', 'produk', 'publikasi', 'prototipe']);
            $table->text('deskripsi')->nullable();
            $table->year('tahun');
            $table->string('tim_penulis')->nullable();

            // Media & tautan publikasi
            $table->string('file_gambar')->nullable();
            $table->string('link_publikasi')->nullable();

            // Fitur unggulan & status tampil
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            // Pengurutan tampilan pada katalog
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
        Schema::dropIfExists('karya_lab');
    }
};
