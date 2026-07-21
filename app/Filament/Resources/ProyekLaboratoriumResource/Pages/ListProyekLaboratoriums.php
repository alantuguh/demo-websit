<?php

namespace App\Filament\Resources\ProyekLaboratoriumResource\Pages;

use App\Filament\Resources\ProyekLaboratoriumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProyekLaboratoriums extends ListRecords
{
    protected static string $resource = ProyekLaboratoriumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Proyek Laboratorium';
    }
}
