<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('👨‍🏫 Menambahkan data dosen laboratorium...');
        
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

        $this->command->info('🎉 Seeder data dosen selesai!');
    }
} 