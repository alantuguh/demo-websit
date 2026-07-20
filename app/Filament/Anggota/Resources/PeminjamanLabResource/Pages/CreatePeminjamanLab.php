<?php

namespace App\Filament\Anggota\Resources\PeminjamanLabResource\Pages;

use App\Filament\Anggota\Resources\PeminjamanLabResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePeminjamanLab extends CreateRecord
{
    protected static string $resource = PeminjamanLabResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Peminjaman lab berhasil diajukan. Menunggu persetujuan admin.';
    }
}
