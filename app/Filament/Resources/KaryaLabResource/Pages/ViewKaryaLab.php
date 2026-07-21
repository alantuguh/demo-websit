<?php

namespace App\Filament\Resources\KaryaLabResource\Pages;

use App\Filament\Resources\KaryaLabResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKaryaLab extends ViewRecord
{
    protected static string $resource = KaryaLabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Lihat Karya Laboratorium';
    }
}
