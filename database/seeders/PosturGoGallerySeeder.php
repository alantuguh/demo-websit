<?php

namespace Database\Seeders;

use App\Models\PrestasiKegiatan;
use Illuminate\Database\Seeder;

/**
 * Mengimpor "Galeri Proyek" dari situs PosturGo (posturgo.ti-uns.com) ke dalam
 * tabel prestasi_kegiatan.
 *
 * Judul dan deskripsi diambil apa adanya dari caption galeri aslinya; tanggal
 * diambil dari judul tiap kartu di sana, bukan dari waktu berkas. Gambarnya
 * sudah disalin ulang ke storage/app/public/prestasi-kegiatan dengan nama
 * berformat tanggal dan diperkecil ke lebar maksimal 1600px.
 *
 * Aman dijalankan berulang: kunci updateOrCreate memakai kolom `gambar` yang
 * unik per entri, sehingga menjalankan seeder dua kali hanya memperbarui baris
 * yang sama, tidak menggandakannya.
 *
 *     php artisan db:seed --class=PosturGoGallerySeeder
 */
class PosturGoGallerySeeder extends Seeder
{
    public function run(): void
    {
        $galeri = [
            [
                'tanggal' => '2025-09-05',
                'judul' => 'PosturGo — Instalasi Tools Pendukung',
                'deskripsi' => 'Instalasi tools pendukung (Gemini CLI, Figma, Claude AI, 3D Blender).',
            ],
            [
                'tanggal' => '2025-09-10',
                'judul' => 'PosturGo — Otomatisasi Bot Telegram dengan n8n',
                'deskripsi' => 'Otomatisasi Bot Telegram dengan n8n (percobaan awal).',
            ],
            [
                'tanggal' => '2025-09-12',
                'judul' => 'PosturGo — Pengembangan Lanjut Bot Telegram n8n',
                'deskripsi' => 'Pengembangan lanjut otomatisasi Bot Telegram n8n.',
            ],
            [
                'tanggal' => '2025-09-17',
                'judul' => 'PosturGo — Belajar Git & GitHub serta CRUD Laravel',
                'deskripsi' => 'Belajar Git & GitHub serta CRUD Laravel.',
            ],
            [
                'tanggal' => '2025-09-19',
                'judul' => 'PosturGo — Pembagian Jobdesk Tim',
                'deskripsi' => 'Pembagian jobdesk: pengembangan web app, pembuatan situs web perusahaan (web company), dan pengelolaan branding sosial media.',
            ],
            [
                'tanggal' => '2025-09-24',
                'judul' => 'PosturGo — Pembuatan Web App dan Company Profile',
                'deskripsi' => 'Mulai melakukan pembuatan web app, web company profile, serta pengelolaan sosial media dengan melakukan pengeditan konten untuk mendukung proses pengembangan dan promosi PosturGo.',
            ],
            [
                'tanggal' => '2025-10-01',
                'judul' => 'PosturGo — Pembuatan Hardware dan 3D Printing',
                'deskripsi' => 'Mulai melakukan pembuatan produk PosturGo (hardware) dan mencetak 3D print.',
            ],
            [
                'tanggal' => '2025-10-08',
                'judul' => 'PosturGo — Penyempurnaan Web App dan Hardware',
                'deskripsi' => 'Melanjutkan pembuatan dan penyempurnaan web app dan produk (hardware) PosturGo.',
            ],
        ];

        // Entri baru diletakkan setelah data yang sudah ada supaya urutan
        // kegiatan lama di halaman publik tidak bergeser.
        $urutan = (int) PrestasiKegiatan::max('sort_order');

        foreach ($galeri as $item) {
            $gambar = 'prestasi-kegiatan/posturgo-' . $item['tanggal'] . '.jpg';

            PrestasiKegiatan::updateOrCreate(
                ['gambar' => $gambar],
                [
                    'judul' => $item['judul'],
                    'deskripsi' => $item['deskripsi'],
                    'jenis' => 'kegiatan',
                    'tanggal' => $item['tanggal'],
                    'is_video' => false,
                    'is_featured' => false,
                    'is_active' => true,
                    'sort_order' => ++$urutan,
                ]
            );
        }

        $this->command->info('Galeri PosturGo: ' . count($galeri) . ' entri disinkronkan.');
    }
}
