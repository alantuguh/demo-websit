<?php

namespace App\Filament\Anggota\Resources\PeminjamanLabResource\Pages;

use App\Filament\Anggota\Resources\PeminjamanLabResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPeminjamanLab extends ViewRecord
{
    protected static string $resource = PeminjamanLabResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => $this->record->status === 'menunggu'),
            Actions\DeleteAction::make()
                ->visible(fn () => $this->record->status === 'menunggu'),
        ];
    }
}
