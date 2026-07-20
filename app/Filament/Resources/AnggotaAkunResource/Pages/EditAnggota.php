<?php

namespace App\Filament\Resources\AnggotaAkunResource\Pages;

use App\Filament\Resources\AnggotaAkunResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAnggota extends EditRecord
{
    protected static string $resource = AnggotaAkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->after(function ($record) {
                    // Hapus password dari session ketika record dihapus
                    $tempPasswords = session('temp_passwords', []);
                    unset($tempPasswords[$record->id]);
                    session(['temp_passwords' => $tempPasswords]);
                }),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Pastikan role selalu anggota saat mengisi form edit
        $data['role'] = 'anggota';
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // FORCE role tetap anggota saat save
        $data['role'] = 'anggota';
        
        // Jika email_verified_at kosong, isi dengan waktu sekarang
        if (empty($data['email_verified_at'])) {
            $data['email_verified_at'] = now();
        }
        
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Simpan password plain jika ada perubahan password
        $plainPassword = null;
        if (!empty($data['password'])) {
            // Kita tidak bisa mendapatkan password plain setelah di-hash
            // Jadi untuk edit, password tetap tidak bisa ditampilkan
        }
        
        // Double check: pastikan role tetap anggota
        $data['role'] = 'anggota';
        
        // Update record
        $record->update($data);
        
        // Verify update berhasil
        $record->refresh();
        
        // Force update lagi jika masih belum benar
        if ($record->role !== 'anggota') {
            $record->forceFill(['role' => 'anggota'])->save();
        }
        
        return $record;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Akun anggota berhasil diperbarui dengan role anggota';
    }
}