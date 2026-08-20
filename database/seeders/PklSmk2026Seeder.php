<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

/**
 * Siswa PKL SMK Negeri 2 Surakarta angkatan 2026, penempatan LPSKE.
 *
 * Sumber: tabel penempatan PKL dari sekolah (kolom kelompok disimpan di
 * study_program, mis. "PPLG K2-4" / "TE K2-1"). Sebagian siswa belum
 * diketahui kelompoknya (study_program null) — lengkapi lewat panel admin.
 * Foto ada di storage/app/public/teams/pkl-2026/ (diunggah terpisah,
 * tidak ikut repo).
 *
 * Idempoten: aman dijalankan berulang (updateOrCreate per nama).
 */
class PklSmk2026Seeder extends Seeder
{
    public function run(): void
    {
        // [nama, kelompok, berkas foto (tanpa folder) atau null]
        $siswa = [
            // PPLG K2-4
            ['Fadlan Khoirul Annam', 'PPLG K2-4', 'fadlan-khoirul-annam.jpg'],
            ['Marcell Dimas Saputra', 'PPLG K2-4', 'marcell-dimas-saputra.jpg'],
            ['Naufal Azzam Hananta', 'PPLG K2-4', 'naufal-azzam-hananta.jpg'],
            ['Ridho Alhasan', 'PPLG K2-4', 'ridho-alhasan.jpg'],

            // PPLG K2-7
            ['Arfan Muhammad Asfar Arroyan', 'PPLG K2-7', 'arfan-muhammad-asfar-arroyan.jpg'],
            ['Satrio Wibowo Sektiaji Putra', 'PPLG K2-7', 'satrio-wibowo-sektiaji-putra.jpg'],
            ['Humam Zada Nahari', 'PPLG K2-7', 'humam-zada-nahari.jpg'],
            ['Ahmad Yulianto Ashari', 'PPLG K2-7', null],

            // PPLG K2-9
            ['Hubert Henry Putra Wijanarko', 'PPLG K2-9', 'hubert-henry-putra-wijanarko.jpg'],
            ['Moch Aldo Yufan Mahendra', 'PPLG K2-9', 'moch-aldo-yufan-mahendra.jpg'],
            ['Muhammad Rajah Aji Gusti Firdaus', 'PPLG K2-9', 'muhammad-rajah-aji-gusti-firdaus.jpg'],
            ['Tomy Anwar Mustofa', 'PPLG K2-9', 'tomy-anwar-mustofa.jpg'],

            // TE K2-1
            ['Davin Ferdinand Azhar', 'TE K2-1', 'davin-ferdinand-azhar.jpg'],
            ['Wahyu Puja Nugraha', 'TE K2-1', 'wahyu-puja-nugraha.jpg'],
            ['Hanun Rafi Ashila', 'TE K2-1', 'hanun-rafi-ashila.jpg'],
            ['Raaid Hilmiy Lastiyono', 'TE K2-1', 'raaid-hilmiy-lastiyono.jpg'],

            // TE K2-2. Nama Andreas terpotong pada dokumen sumber —
            // perbaiki lewat panel admin bila nama lengkapnya diketahui.
            ['Andreas Reynandriel Vinchent Setyav', 'TE K2-2', null],
            ['Yehezkiel Varel Davinda Prasetya', 'TE K2-2', null],
            ['Hilal Maulana Ridho', 'TE K2-2', null],

            // TE K2-3
            ['Shohib Maulana Mirbath', 'TE K2-3', 'shohib-maulana-mirbath.jpg'],
            ['Rayhan Desta Mandala Putra', 'TE K2-3', 'rayhan-desta-mandala-putra.jpg'],
            ['Muhammad Jafar Satya Nugroho', 'TE K2-3', 'muhammad-jafar-satya-nugroho.jpg'],

            // TE K2-5
            ['Fadian Alya Affani', 'TE K2-5', null],
            ['Andre Kuncoro Jati', 'TE K2-5', 'andre-kuncoro-jati.jpg'],
            ['Satria Bayu Laksmana', 'TE K2-5', null],

            // Kelompok belum diketahui (nama dari berkas foto PKL 2026)
            ['Akmal Dzaki Hermawan', null, 'akmal-dzaki-hermawan.jpg'],
            ['Antonius Imanuel Raka Kristianto', null, 'antonius-imanuel-raka-kristianto.jpg'],
            ['Aqilah Littaniya Hartono', null, 'aqilah-littaniya-hartono.jpg'],
            ['Khanda Qeebo Bonggie', null, 'khanda-qeebo-bonggie.jpg'],
            ['Krisna Bagus Riyatno', null, 'krisna-bagus-riyatno.jpg'],
            ['Lovely Azaria Riskya', null, 'lovely-azaria-riskya.jpg'],
            ['Muhammad Khautal Ishomi Yanuar', null, 'muhammad-khautal-ishomi-yanuar.jpg'],
            ['Samuel Lyandro Saputra', null, 'samuel-lyandro-saputra.jpg'],
            ['Vito Orlando Aroditya', null, 'vito-orlando-aroditya.jpg'],
            ['Zulfa Seira Rianti A', null, 'zulfa-seira-rianti-a.jpg'],
        ];

        foreach ($siswa as $i => [$nama, $kelompok, $foto]) {
            Team::updateOrCreate(
                [
                    'type' => 'pkl',
                    'name' => $nama,
                    'angkatan' => 2026,
                ],
                [
                    'position' => 'Siswa PKL SMK Negeri 2 Surakarta',
                    'study_program' => $kelompok,
                    'photo' => $foto ? 'teams/pkl-2026/' . $foto : null,
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
