<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📝 Mengupdate data asisten tanpa foto...');
        
        // Update asisten untuk menghapus referensi foto
        $asistenEmails = [
            'ahmad.fauzi@student.uns.ac.id',
            'siti.nurhaliza@student.uns.ac.id',
            'budi.santoso@student.uns.ac.id',
            'dewi.sartika@student.uns.ac.id',
            'rizki.pratama@student.uns.ac.id',
            'nina.safitri@student.uns.ac.id',
        ];
        
        foreach ($asistenEmails as $email) {
            $asisten = Team::where('email', $email)->first();
            
            if ($asisten) {
                $asisten->update(['photo' => null]);
                $this->command->info("✅ Data {$asisten->name} diupdate (tanpa foto)");
            }
        }
        
        $this->command->info('🎉 Semua data asisten berhasil diupdate!');
        $this->command->info('💡 Asisten akan ditampilkan dengan avatar default yang menarik.');
    }
} 