<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data users dengan berbagai role
        $users = [
            // Admin
            [
                'name' => 'Administrator',
                'email' => 'admin@lpske.com',
                'password' => 'admin123',
                'role' => 'admin',
                'description' => 'Administrator utama sistem'
            ],
            // Asisten
            [
                'name' => 'Asisten LPSKE',
                'email' => 'asisten@lpske.com',
                'password' => 'asisten123',
                'role' => 'asisten',
                'description' => 'Asisten administrator'
            ],
            // Anggota
            [
                'name' => 'Anggota LPSKE',
                'email' => 'anggota@lpske.com',
                'password' => 'anggota123',
                'role' => 'anggota',
                'description' => 'Anggota biasa'
            ]
        ];

        $this->command->info('🚀 Memulai pembuatan akun pengguna...');
        $this->command->info('');

        foreach ($users as $userData) {
            // Cek apakah user sudah ada
            $existingUser = User::where('email', $userData['email'])->first();
            
            if (!$existingUser) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'encrypted_password_storage' => encrypt($userData['password']),
                    'role' => $userData['role'],
                    'email_verified_at' => now(),
                ]);

                $this->command->info("✅ {$userData['description']} berhasil dibuat!");
                $this->command->info("   📧 Email: {$userData['email']}");
                $this->command->info("   🔑 Password: {$userData['password']}");
                $this->command->info("   👤 Role: {$userData['role']}");
                $this->command->info('');
            } else {
                $this->command->info("⚠️  Akun {$userData['role']} ({$userData['email']}) sudah ada!");
                $this->command->info('');
            }
        }

        $this->command->info('🎉 Seeder selesai dijalankan!');
        $this->command->info('');
        $this->command->info('📋 Ringkasan akun yang tersedia:');
        $this->command->info('   • Admin: admin@lpske.com (Admin123!)');
        $this->command->info('   • Asisten: asisten@lpske.com (Asisten123!)');
        $this->command->info('   • Anggota: anggota@lpske.com (Anggota123!)');
    }
}