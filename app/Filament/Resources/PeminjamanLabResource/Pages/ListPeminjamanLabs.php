<?php

namespace App\Filament\Resources\PeminjamanLabResource\Pages;

use App\Filament\Resources\PeminjamanLabResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamanLabs extends ListRecords
{
    protected static string $resource = PeminjamanLabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Peminjaman Lab')
                ->icon('heroicon-o-plus')
                ->modalHeading('Buat Peminjaman Lab'),
        ];
    }
}
