<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pesanan yang masuk dari form di halaman detail produk (/toko/{slug}).
 *
 * Belum ada gateway pembayaran; alurnya: pengunjung mengisi form, pesanan
 * tercatat berstatus "baru", lalu admin menindaklanjuti lewat telepon/
 * WhatsApp/email dan memperbarui statusnya dari panel admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

            $table->string('nama_pemesan');
            $table->string('telepon');
            $table->string('email')->nullable();
            $table->string('instansi')->nullable();
            $table->text('alamat')->nullable();
            $table->unsignedInteger('jumlah')->default(1);
            $table->text('catatan')->nullable();

            // Harga satuan saat memesan, supaya riwayat tidak berubah
            // ketika harga produk diperbarui.
            $table->unsignedBigInteger('harga_saat_pesan');

            $table->enum('status', ['baru', 'dihubungi', 'diproses', 'selesai', 'batal'])
                ->default('baru');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_orders');
    }
};
