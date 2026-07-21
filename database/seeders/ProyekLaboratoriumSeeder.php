<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProyekLaboratorium;

class ProyekLaboratoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai pembuatan data proyek laboratorium LPSKE...');

        $data = [
            [
                'judul_proyek' => 'Program Wibawa Laboratorium LPSKE 2025',
                'kategori' => 'wibawa',
                'deskripsi' => 'Program pengembangan wibawa laboratorium sebagai pusat unggulan riset dan layanan bidang perancangan sistem kerja dan ergonomi.',
                'tahun' => 2025,
                'mitra' => 'Fakultas Teknik UNS',
                'status' => 'berjalan',
                'link_terkait' => null,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'judul_proyek' => 'Jaringan Pengembangan Akademik (Jarpak) LPSKE',
                'kategori' => 'jarpak',
                'deskripsi' => 'Kegiatan kerja sama jaringan pengembangan akademik antar laboratorium dan program studi Teknik Industri.',
                'tahun' => 2025,
                'mitra' => 'Program Studi Teknik Industri UNS',
                'status' => 'berjalan',
                'link_terkait' => null,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'judul_proyek' => 'Semesta: Sinergi Mahasiswa dan Industri',
                'kategori' => 'semesta',
                'deskripsi' => 'Proyek kolaborasi mahasiswa dan mitra industri untuk penerapan keilmuan ergonomi pada UMKM dan industri kecil.',
                'tahun' => 2024,
                'mitra' => 'UMKM Mitra Binaan',
                'status' => 'selesai',
                'link_terkait' => null,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'judul_proyek' => 'Hibah Penelitian DIKTI Bidang Ergonomi Industri',
                'kategori' => 'dikti',
                'deskripsi' => 'Proyek penelitian yang didanai oleh Direktorat Jenderal Pendidikan Tinggi untuk pengembangan keilmuan ergonomi industri.',
                'tahun' => 2024,
                'mitra' => 'Kemendikbudristek (DIKTI)',
                'status' => 'selesai',
                'link_terkait' => null,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'judul_proyek' => 'Kerja Sama Riset Terapan dengan UNS',
                'kategori' => 'kerjasama_uns',
                'deskripsi' => 'Kerja sama riset terapan lintas laboratorium bersama unit-unit lain di lingkungan Universitas Sebelas Maret.',
                'tahun' => 2025,
                'mitra' => 'Universitas Sebelas Maret',
                'status' => 'berjalan',
                'link_terkait' => null,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($data as $item) {
            ProyekLaboratorium::updateOrCreate(
                ['judul_proyek' => $item['judul_proyek']],
                $item
            );
        }

        $this->command->info('✅ Data proyek laboratorium berhasil dibuat.');
    }
}
