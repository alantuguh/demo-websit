<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Tambah nilai 'pkl' (siswa PKL SMK) pada enum teams.type.
 *
 * Sekalian menambah 'anggota' yang sudah lama ditawarkan form TeamResource
 * di panel admin tetapi belum pernah ada di enum database — memilihnya
 * selama ini akan gagal saat simpan.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE teams MODIFY COLUMN type ENUM('kepala', 'dosen', 'asisten', 'anggota', 'pkl') NOT NULL");
    }

    public function down(): void
    {
        // Baris bertipe baru harus disingkirkan dulu; kalau tidak, MySQL
        // menolak menyempitkan enum.
        DB::table('teams')->whereIn('type', ['anggota', 'pkl'])->delete();
        DB::statement("ALTER TABLE teams MODIFY COLUMN type ENUM('kepala', 'dosen', 'asisten') NOT NULL");
    }
};
