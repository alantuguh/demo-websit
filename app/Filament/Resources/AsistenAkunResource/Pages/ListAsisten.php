<?php

namespace App\Filament\Resources\AsistenAkunResource\Pages;

use App\Filament\Resources\AsistenAkunResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsisten extends ListRecords
{
    protected static string $resource = AsistenAkunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->label('Tambah Akun')
                ->icon('heroicon-o-plus')
                ->modalHeading('Tambah Akun'),
        ];
    }
}
