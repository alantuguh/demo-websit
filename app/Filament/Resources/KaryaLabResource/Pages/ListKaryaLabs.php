<?php

namespace App\Filament\Resources\KaryaLabResource\Pages;

use App\Filament\Resources\KaryaLabResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKaryaLabs extends ListRecords
{
    protected static string $resource = KaryaLabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Katalog Produk & Karya';
    }
}
