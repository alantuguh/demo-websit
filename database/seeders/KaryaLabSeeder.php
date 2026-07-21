<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KaryaLab;

class KaryaLabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai pembuatan data katalog produk & karya LPSKE...');

        $data = [
            [
                'nama_karya' => 'Analisis Beban Kerja Mental Operator Produksi Menggunakan Metode NASA-TLX',
                'kategori' => 'penelitian',
                'deskripsi' => 'Penelitian mengenai pengukuran beban kerja mental operator lini produksi menggunakan metode NASA Task Load Index (NASA-TLX) sebagai dasar rekomendasi perbaikan sistem kerja.',
                'tahun' => 2025,
                'tim_penulis' => 'Naufal Daaris Farqad, Muhamad Haikal Rizaldi',
                'link_publikasi' => null,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'nama_karya' => 'Purwarupa Meja Kerja Ergonomis untuk UMKM',
                'kategori' => 'prototipe',
                'deskripsi' => 'Purwarupa meja kerja yang dirancang berdasarkan prinsip antropometri untuk meningkatkan kenyamanan dan produktivitas pekerja UMKM sektor manufaktur skala kecil.',
                'tahun' => 2025,
                'tim_penulis' => 'Alan Tuguh Wibowo',
                'link_publikasi' => null,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'nama_karya' => 'Modul Ajar Praktikum Perancangan Sistem Kerja dan Ergonomi',
                'kategori' => 'produk',
                'deskripsi' => 'Modul ajar praktikum yang digunakan sebagai panduan pelaksanaan praktikum di Laboratorium LPSKE, mencakup teori dan lembar kerja mahasiswa.',
                'tahun' => 2024,
                'tim_penulis' => 'Tim Asisten LPSKE',
                'link_publikasi' => null,
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'nama_karya' => 'Studi Ergonomi Kognitif pada Antarmuka Sistem Informasi Laboratorium',
                'kategori' => 'publikasi',
                'deskripsi' => 'Artikel yang membahas penerapan prinsip ergonomi kognitif pada perancangan antarmuka sistem informasi laboratorium berbasis web.',
                'tahun' => 2024,
                'tim_penulis' => 'Muhamad Haikal Rizaldi',
                'link_publikasi' => 'https://example.com/publikasi/ergonomi-kognitif-sil',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($data as $item) {
            KaryaLab::updateOrCreate(
                ['nama_karya' => $item['nama_karya']],
                $item
            );
        }

        $this->command->info('✅ Data katalog produk & karya berhasil dibuat.');
    }
}
