<?php

namespace App\Filament\Resources\PeminjamanLabResource\Pages;

use App\Filament\Resources\PeminjamanLabResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePeminjamanLab extends CreateRecord
{
    protected static string $resource = PeminjamanLabResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'menunggu';
        
        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Pengajuan peminjaman lab berhasil dibuat dan sedang menunggu persetujuan';
    }
}
