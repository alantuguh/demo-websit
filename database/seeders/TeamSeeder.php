<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai pembuatan data tim LPSKE...');
        
        // Data asisten
        $asistenData = [
            [
                'type' => 'asisten',
                'name' => 'Ahmad Fauzi',
                'nim' => 'G1A020001',
                'position' => 'Asisten Laboratorium',
                'study_program' => 'Teknik Industri',
                'expertise' => 'Ergonomi & Perancangan Sistem Kerja',
                'email' => 'ahmad.fauzi@student.uns.ac.id',
                'phone' => '081234567890',
                'angkatan' => 2020,
                'bio' => 'Asisten laboratorium yang fokus pada bidang ergonomi dan perancangan sistem kerja.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'type' => 'asisten',
                'name' => 'Siti Nurhaliza',
                'nim' => 'G1A020002',
                'position' => 'Asisten Laboratorium',
                'study_program' => 'Teknik Industri',
                'expertise' => 'Ergonomi & Antropometri',
                'email' => 'siti.nurhaliza@student.uns.ac.id',
                'phone' => '081234567891',
                'angkatan' => 2020,
                'bio' => 'Asisten laboratorium yang ahli dalam pengukuran antropometri dan analisis postur kerja.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'type' => 'asisten',
                'name' => 'Budi Santoso',
                'nim' => 'G1A020003',
                'position' => 'Asisten Laboratorium',
                'study_program' => 'Teknik Industri',
                'expertise' => 'Perancangan Sistem Kerja',
                'email' => 'budi.santoso@student.uns.ac.id',
                'phone' => '081234567892',
                'angkatan' => 2021,
                'bio' => 'Asisten laboratorium yang fokus pada perancangan sistem kerja dan metode kerja.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'type' => 'asisten',
                'name' => 'Dewi Sartika',
                'nim' => 'G1A020004',
                'position' => 'Asisten Laboratorium',
                'study_program' => 'Teknik Industri',
                'expertise' => 'Ergonomi Kognitif',
                'email' => 'dewi.sartika@student.uns.ac.id',
                'phone' => '081234567893',
                'angkatan' => 2021,
                'bio' => 'Asisten laboratorium yang ahli dalam ergonomi kognitif dan desain antarmuka.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'type' => 'asisten',
                'name' => 'Rizki Pratama',
                'nim' => 'G1A020005',
                'position' => 'Asisten Laboratorium',
                'study_program' => 'Teknik Industri',
                'expertise' => 'Ergonomi Fisik',
                'email' => 'rizki.pratama@student.uns.ac.id',
                'phone' => '081234567894',
                'angkatan' => 2022,
                'bio' => 'Asisten laboratorium yang fokus pada ergonomi fisik dan analisis biomekanika.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'type' => 'asisten',
                'name' => 'Nina Safitri',
                'nim' => 'G1A020006',
                'position' => 'Asisten Laboratorium',
                'study_program' => 'Teknik Industri',
                'expertise' => 'Ergonomi Lingkungan',
                'email' => 'nina.safitri@student.uns.ac.id',
                'phone' => '081234567895',
                'angkatan' => 2022,
                'bio' => 'Asisten laboratorium yang ahli dalam ergonomi lingkungan dan pengukuran iklim kerja.',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($asistenData as $data) {
            $existingTeam = Team::where('email', $data['email'])->first();
            
            if (!$existingTeam) {
                Team::create($data);
                $this->command->info("✅ Asisten {$data['name']} berhasil dibuat!");
            } else {
                $this->command->info("⚠️  Asisten {$data['name']} sudah ada!");
            }
        }

        // Data kepala laboratorium
        $kepalaData = [
            'type' => 'kepala',
            'name' => 'Dr. Ir. Bambang Setiawan, M.T.',
            'nip' => '196501011990031001',
            'position' => 'Kepala Laboratorium',
            'study_program' => 'Teknik Industri',
            'expertise' => 'Ergonomi & Perancangan Sistem Kerja',
            'email' => 'bambang.setiawan@uns.ac.id',
            'phone' => '081234567896',
            'bio' => 'Kepala Laboratorium Perancangan Sistem Kerja dan Ergonomi (LPSKE) yang memiliki pengalaman lebih dari 20 tahun dalam bidang ergonomi dan perancangan sistem kerja.',
            'is_active' => true,
            'sort_order' => 1,
        ];

        $existingKepala = Team::where('type', 'kepala')->first();
        if (!$existingKepala) {
            Team::create($kepalaData);
            $this->command->info("✅ Kepala Laboratorium {$kepalaData['name']} berhasil dibuat!");
        } else {
            $this->command->info("⚠️  Kepala Laboratorium sudah ada!");
        }

        // Data dosen
        $dosenData = [
            [
                'type' => 'dosen',
                'name' => 'Ir. Siti Aminah, M.T.',
                'nip' => '197002011990032001',
                'position' => 'Dosen Pembina',
                'study_program' => 'Teknik Industri',
                'expertise' => 'Ergonomi & Antropometri',
                'email' => 'siti.aminah@uns.ac.id',
                'phone' => '081234567897',
                'bio' => 'Dosen pembina yang ahli dalam bidang ergonomi dan antropometri.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'type' => 'dosen',
                'name' => 'Ir. Ahmad Hidayat, M.T.',
                'nip' => '197503011990031002',
                'position' => 'Dosen Pembina',
                'study_program' => 'Teknik Industri',
                'expertise' => 'Perancangan Sistem Kerja',
                'email' => 'ahmad.hidayat@uns.ac.id',
                'phone' => '081234567898',
                'bio' => 'Dosen pembina yang fokus pada perancangan sistem kerja dan metode kerja.',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($dosenData as $data) {
            $existingDosen = Team::where('email', $data['email'])->first();
            
            if (!$existingDosen) {
                Team::create($data);
                $this->command->info("✅ Dosen {$data['name']} berhasil dibuat!");
            } else {
                $this->command->info("⚠️  Dosen {$data['name']} sudah ada!");
            }
        }

        $this->command->info('🎉 Seeder data tim LPSKE selesai!');
    }
} 