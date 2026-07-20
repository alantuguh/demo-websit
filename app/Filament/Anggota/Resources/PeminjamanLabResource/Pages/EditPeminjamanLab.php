<?php

namespace App\Filament\Anggota\Resources\PeminjamanLabResource\Pages;

use App\Filament\Anggota\Resources\PeminjamanLabResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeminjamanLab extends EditRecord
{
    protected static string $resource = PeminjamanLabResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Peminjaman lab berhasil diperbarui.';
    }
}
