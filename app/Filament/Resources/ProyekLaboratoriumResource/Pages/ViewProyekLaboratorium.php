<?php

namespace App\Filament\Resources\ProyekLaboratoriumResource\Pages;

use App\Filament\Resources\ProyekLaboratoriumResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProyekLaboratorium extends ViewRecord
{
    protected static string $resource = ProyekLaboratoriumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Lihat Proyek Laboratorium';
    }
}
