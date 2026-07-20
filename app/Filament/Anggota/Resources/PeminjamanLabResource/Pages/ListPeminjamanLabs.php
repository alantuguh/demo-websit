<?php

namespace App\Filament\Anggota\Resources\PeminjamanLabResource\Pages;

use App\Filament\Anggota\Resources\PeminjamanLabResource;
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
                ->icon('heroicon-o-plus'),
        ];
    }
}
