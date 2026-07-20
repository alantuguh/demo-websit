<?php

namespace App\Filament\Asisten\Resources\PresensiResource\Pages;

use App\Filament\Asisten\Resources\PresensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPresensis extends ListRecords
{
    protected static string $resource = PresensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    public function getTitle(): string 
    {
        return 'Presensi';
    }
}
