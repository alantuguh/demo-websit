<?php

namespace App\Filament\Anggota\Resources\PerizinanResource\Pages;

use App\Filament\Anggota\Resources\PerizinanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPerizinans extends ListRecords
{
    protected static string $resource = PerizinanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajukan Perizinan'),
        ];
    }

    public function getTitle(): string 
    {
        return 'Perizinan';
    }

}
