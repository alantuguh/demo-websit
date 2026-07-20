<?php

namespace App\Filament\Resources\AnggotaAkunResource\Pages;

use App\Filament\Resources\AnggotaAkunResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnggotas extends ListRecords
{
    protected static string $resource = AnggotaAkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Anggota')
                ->icon('heroicon-o-plus'),
        ];
    }
}