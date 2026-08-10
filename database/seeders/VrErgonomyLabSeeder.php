<?php

namespace Database\Seeders;

use App\Models\VrModule;
use App\Models\VrRoom;
use Illuminate\Database\Seeder;

/**
 * Kerangka awal VR Ergonomy Lab: 6 ruang tematik beserta modul rencananya.
 *
 * Ruang disusun mengikuti alur praktikum ergonomi di LPSKE — dari mengukur
 * tubuh (antropometri), menilai postur, mengukur lingkungan kerja, sampai
 * merancang ulang sistem kerja. Dua ruang terakhir sengaja bertaut dengan
 * produk LPSKE yang sudah ada: Ruang Simulasi Berkendara dengan ErgoDrive dan
 * Fumorive, Ruang Kognitif dengan BrainNova dan Neuro Academy.
 *
 * Seluruh modul dibuat berstatus 'rencana' atau 'pengembangan' — katalognya
 * memang dirilis lebih dulu, isi produk sesungguhnya menyusul. Judul dan
 * durasi di sini adalah kerangka yang dimaksudkan untuk disunting lewat panel
 * admin, bukan spesifikasi final.
 *
 * Aman dijalankan berulang: ruang dikunci pada slug, modul dikunci pada
 * pasangan (ruang, judul).
 *
 *     php artisan db:seed --class=VrErgonomyLabSeeder
 */
class VrErgonomyLabSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->rooms() as $urutan => $data) {
            $room = VrRoom::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'nama' => $data['nama'],
                    'tema' => $data['tema'],
                    'deskripsi' => $data['deskripsi'],
                    'capaian' => $data['capaian'],
                    'ikon' => $data['ikon'],
                    'warna' => $data['warna'],
                    'is_active' => true,
                    'sort_order' => $urutan + 1,
                ]
            );

            foreach ($data['modules'] as $i => $modul) {
                VrModule::updateOrCreate(
                    ['vr_room_id' => $room->id, 'judul' => $modul['judul']],
                    [
                        'deskripsi' => $modul['deskripsi'],
                        'level' => $modul['level'],
                        'status' => $modul['status'],
                        'durasi_menit' => $modul['durasi'],
                        'perangkat' => $modul['perangkat'],
                        'is_active' => true,
                        'sort_order' => $i + 1,
                    ]
                );
            }
        }

        $this->command->info(sprintf(
            'VR Ergonomy Lab: %d ruang, %d modul disinkronkan.',
            VrRoom::count(),
            VrModule::count()
        ));
    }

    private function rooms(): array
    {
        return [
            [
                'slug' => 'antropometri',
                'nama' => 'Ruang Antropometri',
                'tema' => 'Pengukuran dimensi tubuh',
                'ikon' => 'fa-ruler-combined',
                'warna' => '#2f5fe0',
                'deskripsi' => 'Ruang pengukuran dimensi tubuh pada avatar virtual. Mahasiswa mengambil data antropometri statis maupun dinamis, mengolahnya menjadi persentil, lalu memakainya sebagai dasar perancangan stasiun kerja.',
                'capaian' => [
                    'Mengukur dimensi tubuh statis dan dinamis pada avatar virtual',
                    'Mengolah data hasil ukur menjadi persentil 5, 50, dan 95',
                    'Menentukan dimensi rancangan stasiun kerja dari data persentil',
                ],
                'modules' => [
                    [
                        'judul' => 'Pengukuran Antropometri Statis',
                        'deskripsi' => 'Mengukur dimensi tubuh pada posisi diam: tinggi badan, tinggi bahu, jangkauan tangan, dan seterusnya.',
                        'level' => 'dasar', 'status' => 'rencana', 'durasi' => 30, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Pengukuran Antropometri Dinamis',
                        'deskripsi' => 'Mengukur jangkauan dan ruang gerak saat tubuh bergerak, termasuk zona kerja normal dan maksimum.',
                        'level' => 'menengah', 'status' => 'rencana', 'durasi' => 40, 'perangkat' => 'VR Headset + Controller',
                    ],
                    [
                        'judul' => 'Penentuan Persentil dan Dimensi Rancangan',
                        'deskripsi' => 'Mengolah data kelas menjadi persentil dan menerapkannya pada rancangan meja, kursi, serta letak alat.',
                        'level' => 'menengah', 'status' => 'rencana', 'durasi' => 45, 'perangkat' => 'Desktop',
                    ],
                ],
            ],
            [
                'slug' => 'postur-biomekanika',
                'nama' => 'Ruang Postur & Biomekanika',
                'tema' => 'Penilaian postur kerja',
                'ikon' => 'fa-person-walking',
                'warna' => '#0e7490',
                'deskripsi' => 'Ruang untuk mengamati dan menilai postur kerja berisiko. Skenario dijalankan pada stasiun kerja virtual sehingga postur ekstrem dapat diperagakan tanpa memaparkan mahasiswa pada risiko cedera.',
                'capaian' => [
                    'Mengidentifikasi postur kerja berisiko pada stasiun kerja simulasi',
                    'Menghitung skor RULA dan REBA dari postur yang diamati',
                    'Mengusulkan perbaikan postur dan mengukur penurunan skor risikonya',
                ],
                'modules' => [
                    [
                        'judul' => 'Penilaian Postur dengan RULA',
                        'deskripsi' => 'Menilai postur tubuh bagian atas pada pekerjaan berulang dan menghitung skor akhir RULA.',
                        'level' => 'dasar', 'status' => 'rencana', 'durasi' => 35, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Penilaian Postur dengan REBA',
                        'deskripsi' => 'Menilai postur seluruh tubuh pada pekerjaan dengan beban dan mengevaluasi tingkat tindakan yang diperlukan.',
                        'level' => 'menengah', 'status' => 'rencana', 'durasi' => 35, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Analisis Manual Material Handling',
                        'deskripsi' => 'Simulasi aktivitas angkat-angkut untuk menghitung batas beban yang direkomendasikan dan indeks pengangkatan.',
                        'level' => 'lanjut', 'status' => 'rencana', 'durasi' => 50, 'perangkat' => 'VR Headset + Controller',
                    ],
                ],
            ],
            [
                'slug' => 'lingkungan-kerja',
                'nama' => 'Ruang Lingkungan Kerja',
                'tema' => 'Iklim, cahaya, dan kebisingan',
                'ikon' => 'fa-temperature-half',
                'warna' => '#7c3aed',
                'deskripsi' => 'Ruang pengukuran faktor fisik lingkungan kerja. Kondisi yang sulit dihadirkan di laboratorium fisik — suhu ekstrem, kebisingan tinggi — dapat diatur bebas pada simulasi.',
                'capaian' => [
                    'Mengukur suhu, kelembapan, pencahayaan, dan kebisingan pada stasiun kerja virtual',
                    'Membandingkan hasil ukur dengan nilai ambang batas yang berlaku',
                    'Merancang perbaikan lingkungan kerja berdasarkan hasil pengukuran',
                ],
                'modules' => [
                    [
                        'judul' => 'Pengukuran Iklim Kerja',
                        'deskripsi' => 'Mengukur suhu, kelembapan, dan tekanan panas pada beberapa titik stasiun kerja.',
                        'level' => 'dasar', 'status' => 'rencana', 'durasi' => 30, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Pengukuran Pencahayaan',
                        'deskripsi' => 'Mengukur tingkat pencahayaan dan menilai kecukupannya terhadap jenis pekerjaan yang dilakukan.',
                        'level' => 'dasar', 'status' => 'rencana', 'durasi' => 25, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Pengukuran Kebisingan dan Getaran',
                        'deskripsi' => 'Memetakan tingkat kebisingan dan paparan getaran, lalu menghitung durasi pemaparan yang masih aman.',
                        'level' => 'menengah', 'status' => 'rencana', 'durasi' => 35, 'perangkat' => 'VR Headset',
                    ],
                ],
            ],
            [
                'slug' => 'simulasi-berkendara',
                'nama' => 'Ruang Simulasi Berkendara',
                'tema' => 'Ergonomi kabin & kewaspadaan',
                'ikon' => 'fa-car-side',
                'warna' => '#b46908',
                'deskripsi' => 'Ruang simulasi mengemudi untuk menilai ergonomi kabin dan kewaspadaan pengemudi. Bertaut langsung dengan dua produk LPSKE yang sudah berjalan: ErgoDrive dan Fumorive.',
                'capaian' => [
                    'Menilai jangkauan dan postur pengemudi pada berbagai tata letak kabin',
                    'Mengamati penurunan kewaspadaan pada perjalanan berdurasi panjang',
                    'Mengaitkan hasil simulasi dengan pengukuran ErgoDrive dan Fumorive',
                ],
                'modules' => [
                    [
                        'judul' => 'Ergonomi Tata Letak Kabin',
                        'deskripsi' => 'Menilai posisi kemudi, pedal, dan panel instrumen terhadap jangkauan pengemudi dari berbagai persentil tubuh.',
                        'level' => 'dasar', 'status' => 'rencana', 'durasi' => 30, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Simulasi Kelelahan Pengemudi',
                        'deskripsi' => 'Skenario berkendara jarak jauh untuk mengamati tanda kelelahan dini, selaras dengan pendekatan yang dipakai Fumorive.',
                        'level' => 'menengah', 'status' => 'pengembangan', 'durasi' => 45, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Uji Waktu Reaksi Pengereman',
                        'deskripsi' => 'Mengukur waktu reaksi pengemudi terhadap kejadian mendadak pada berbagai tingkat kelelahan dan gangguan.',
                        'level' => 'lanjut', 'status' => 'rencana', 'durasi' => 40, 'perangkat' => 'VR Headset + Controller',
                    ],
                ],
            ],
            [
                'slug' => 'sistem-kerja',
                'nama' => 'Ruang Perancangan Sistem Kerja',
                'tema' => 'Studi waktu, gerak, dan tata letak',
                'ikon' => 'fa-diagram-project',
                'warna' => '#0d9488',
                'deskripsi' => 'Ruang untuk membedah dan merancang ulang proses kerja. Mahasiswa dapat mengubah tata letak stasiun kerja lalu langsung menjalankan ulang prosesnya untuk melihat dampaknya.',
                'capaian' => [
                    'Melakukan studi waktu dan gerak pada proses kerja virtual',
                    'Menyusun peta tangan kiri–tangan kanan dari proses yang diamati',
                    'Merancang ulang tata letak stasiun kerja dan mengukur perubahan waktu siklusnya',
                ],
                'modules' => [
                    [
                        'judul' => 'Studi Waktu dan Waktu Baku',
                        'deskripsi' => 'Mengukur waktu siklus proses kerja, menetapkan faktor penyesuaian dan kelonggaran, lalu menghitung waktu baku.',
                        'level' => 'dasar', 'status' => 'rencana', 'durasi' => 40, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Peta Tangan Kiri–Tangan Kanan',
                        'deskripsi' => 'Merekam gerakan kedua tangan pada perakitan sederhana dan menyusun petanya untuk menemukan gerakan mubazir.',
                        'level' => 'menengah', 'status' => 'rencana', 'durasi' => 35, 'perangkat' => 'VR Headset + Controller',
                    ],
                    [
                        'judul' => 'Perancangan Ulang Tata Letak',
                        'deskripsi' => 'Menyusun ulang letak alat dan material, lalu membandingkan waktu siklus sebelum dan sesudah perbaikan.',
                        'level' => 'lanjut', 'status' => 'rencana', 'durasi' => 55, 'perangkat' => 'VR Headset + Controller',
                    ],
                ],
            ],
            [
                'slug' => 'kognitif-beban-mental',
                'nama' => 'Ruang Kognitif & Beban Mental',
                'tema' => 'Beban mental dan atensi',
                'ikon' => 'fa-brain',
                'warna' => '#db2777',
                'deskripsi' => 'Ruang pengukuran beban kerja mental dan atensi. Bertaut dengan lini neurotechnology LPSKE — BrainNova dan Neuro Academy — untuk memadukan hasil kuesioner dengan pengukuran sinyal otak.',
                'capaian' => [
                    'Mengukur beban kerja mental dengan NASA-TLX pada tugas virtual',
                    'Mengamati pengaruh gangguan terhadap atensi dan ketelitian kerja',
                    'Mengaitkan hasil pengukuran subjektif dengan data sinyal otak (EEG)',
                ],
                'modules' => [
                    [
                        'judul' => 'Pengukuran Beban Mental NASA-TLX',
                        'deskripsi' => 'Menjalankan tugas dengan tingkat kesulitan bertingkat lalu mengisi kuesioner NASA-TLX untuk tiap tingkat.',
                        'level' => 'dasar', 'status' => 'rencana', 'durasi' => 30, 'perangkat' => 'Desktop',
                    ],
                    [
                        'judul' => 'Uji Atensi dan Gangguan Kerja',
                        'deskripsi' => 'Mengamati penurunan ketelitian saat pekerja menerima gangguan suara maupun visual di tengah tugas.',
                        'level' => 'menengah', 'status' => 'rencana', 'durasi' => 35, 'perangkat' => 'VR Headset',
                    ],
                    [
                        'judul' => 'Integrasi Pengukuran EEG',
                        'deskripsi' => 'Menyandingkan rekaman gelombang otak dengan skor beban mental yang dilaporkan peserta selama simulasi berlangsung.',
                        'level' => 'lanjut', 'status' => 'pengembangan', 'durasi' => 50, 'perangkat' => 'VR Headset + EEG',
                    ],
                ],
            ],
        ];
    }
}
