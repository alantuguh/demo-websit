<?php

namespace App\Filament\Resources\VrRoomResource\Pages;

use App\Filament\Resources\VrRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVrRoom extends ViewRecord
{
    protected static string $resource = VrRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Lihat Ruang VR';
    }
}
