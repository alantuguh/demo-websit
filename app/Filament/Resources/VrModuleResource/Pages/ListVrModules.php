<?php

namespace App\Filament\Resources\VrModuleResource\Pages;

use App\Filament\Resources\VrModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVrModules extends ListRecords
{
    protected static string $resource = VrModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Modul VR';
    }
}
