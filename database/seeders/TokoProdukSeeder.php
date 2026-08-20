<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

/**
 * Produk perdana Toko LPSKE: paket simulator driving untuk uji ergonomi
 * kemudi. Foto memakai dokumentasi simulator lab yang sudah ada di
 * public/images/products, disalin ke storage publik agar konsisten dengan
 * unggahan dari panel admin.
 *
 * Idempoten: aman dijalankan berulang.
 */
class TokoProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Foto produk dari dokumentasi yang sudah ada
        $fotoUtama = $this->salinFoto('simulator-lab.jpg');
        $fotoGaleri = $this->salinFoto('simulator-lab-2.jpg');

        Product::updateOrCreate(
            ['slug' => 'simulator-driving-uji-ergonomi-kemudi'],
            [
                'nama' => 'Simulator Driving — Paket Rig + Game Uji Ergonomi Kemudi',
                'kategori' => 'Simulator',
                'deskripsi' => 'Paket lengkap simulator mengemudi untuk pengujian ergonomi kemudi: '
                    . 'penelitian postur berkendara, penilaian desain kabin, hingga praktikum '
                    . 'ergonomi transportasi. Satu paket sudah mencakup seluruh perangkat keras '
                    . 'dan perangkat lunak — tinggal nyalakan dan pakai. Dirakit serta dikalibrasi '
                    . 'oleh tim LPSKE, termasuk pendampingan instalasi di lokasi Anda.',
                'harga' => 40000000,
                'kelengkapan' => [
                    'PC siap pakai (terinstal game/software uji ergonomi kemudi)',
                    'Rig simulator driving (kursi, kemudi, pedal)',
                    '3 unit TV 27 inci (tampilan panorama tiga layar)',
                    'UPS (pelindung daya)',
                    'Dongle WiFi',
                    'Perakitan, kalibrasi, dan pendampingan instalasi',
                ],
                'gambar' => $fotoUtama,
                'galeri' => array_values(array_filter([$fotoGaleri])),
                'stok' => null, // dirakit sesuai pesanan
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }

    /**
     * Salin foto dari public/images/products ke storage toko bila ada.
     * Mengembalikan path relatif storage, atau null bila sumber tidak ada.
     */
    private function salinFoto(string $nama): ?string
    {
        $sumber = public_path('images/products/' . $nama);
        if (!File::exists($sumber)) {
            return null;
        }

        $tujuanDir = storage_path('app/public/toko');
        File::ensureDirectoryExists($tujuanDir);
        File::copy($sumber, $tujuanDir . '/' . $nama);

        return 'toko/' . $nama;
    }
}
