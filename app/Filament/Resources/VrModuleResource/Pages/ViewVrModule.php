<?php

namespace App\Filament\Resources\VrModuleResource\Pages;

use App\Filament\Resources\VrModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVrModule extends ViewRecord
{
    protected static string $resource = VrModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Lihat Modul VR';
    }
}
