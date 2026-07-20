<?php

namespace App\Filament\Resources\AnggotaAkunResource\Pages;

use App\Filament\Resources\AnggotaAkunResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class CreateAnggota extends CreateRecord
{
    protected static string $resource = AnggotaAkunResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set default role
        $data['role'] = 'anggota';
        
        $plainPassword = null;
        
        // Handle password generation or manual input
        if (isset($data['generate_random_password']) && $data['generate_random_password']) {
            $plainPassword = $this->generateSecurePassword();
            $data['password'] = Hash::make($plainPassword);
            
            Notification::make()
                ->title('Password Acak Berhasil Dibuat')
                ->body("Password untuk {$data['name']}: {$plainPassword}")
                ->success()
                ->duration(15000)
                ->send();
        } else {
            // Ambil password yang diinput manual
            $plainPassword = $data['password'] ?? null;
            if ($plainPassword) {
                $data['password'] = Hash::make($plainPassword);
            }
        }
        
        // Simpan encrypted password jika diperlukan
        if ($plainPassword && isset($data['store_password_for_admin']) && $data['store_password_for_admin']) {
            // Password akan disimpan melalui model method setelah create
            $this->passwordToStore = $plainPassword;
        }
        
        // Clean up form data
        unset($data['generate_random_password']);
        unset($data['store_password_for_admin']);
        unset($data['password_confirmation']);
        
        return $data;
    }

    private $passwordToStore = null;

    protected function afterCreate(): void
    {
        // Simpan encrypted password setelah user dibuat
        if ($this->passwordToStore && $this->record) {
            $this->record->setPlainPasswordForAdmin($this->passwordToStore);
        }
        
        // Clear password dari memory
        $this->passwordToStore = null;
    }

    /**
     * Generate secure password
     */
    private function generateSecurePassword(): string
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*';
        
        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];
        
        $allChars = $uppercase . $lowercase . $numbers . $symbols;
        for ($i = 4; $i < 12; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }
        
        return str_shuffle($password);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Akun anggota berhasil dibuat dengan aman';
    }
}