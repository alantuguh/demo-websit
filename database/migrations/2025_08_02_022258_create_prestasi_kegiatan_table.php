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
        Schema::create('prestasi_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            
            // Media
            $table->string('gambar')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('is_video')->default(false);
            
            // Kategori dan Tanggal
            $table->enum('jenis', ['prestasi', 'kegiatan']);
            $table->date('tanggal');
            
            // Fitur Unggulan
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('featured_at')->nullable();
            
            // Pengurutan
            $table->integer('sort_order')->default(0);
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_kegiatan');
    }
};
