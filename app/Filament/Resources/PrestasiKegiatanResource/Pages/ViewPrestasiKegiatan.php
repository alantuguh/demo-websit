<?php

namespace App\Filament\Resources\PrestasiKegiatanResource\Pages;

use App\Filament\Resources\PrestasiKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPrestasiKegiatan extends ViewRecord
{
    protected static string $resource = PrestasiKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string 
    {
        return 'Lihat Prestasi & Kegiatan';
    }
}
