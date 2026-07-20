<?php

namespace App\Filament\Resources\PrestasiKegiatanResource\Pages;

use App\Filament\Resources\PrestasiKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrestasiKegiatans extends ListRecords
{
    protected static string $resource = PrestasiKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string 
    {
        return 'Prestasi & Kegiatan';
    }
}
