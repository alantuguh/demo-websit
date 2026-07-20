<?php

namespace App\Filament\Anggota\Resources\InventoryItemResource\Pages;

use App\Filament\Anggota\Resources\InventoryItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventoryItems extends ListRecords
{
    protected static string $resource = InventoryItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string 
    {
        return 'Daftar Alat & Barang';
    }
}
