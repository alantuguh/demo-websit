<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $columns = [
                'status_pinjam',
                'peminjam_id',
                'jumlah_dipinjam',
                'tanggal_pinjam',
                'tanggal_kembali',
                'alasan_pinjam',
                'catatan_admin',
                'status_persetujuan'
            ];
            
            // Drop foreign key constraints first if they exist
            if (Schema::hasColumn('inventory_items', 'peminjam_id')) {
                $table->dropForeign(['peminjam_id']);
            }
            
            // Drop columns if they exist
            foreach ($columns as $column) {
                if (Schema::hasColumn('inventory_items', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->enum('status_pinjam', ['tersedia', 'dipinjam', 'diproses'])->default('tersedia');
            $table->foreignId('peminjam_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('jumlah_dipinjam')->default(0);
            $table->dateTime('tanggal_pinjam')->nullable();
            $table->dateTime('tanggal_kembali')->nullable();
            $table->text('alasan_pinjam')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->enum('status_persetujuan', ['menunggu', 'disetujui', 'ditolak'])->nullable();
        });
    }
};
