<?php

namespace App\Filament\Resources\VrRoomResource\Pages;

use App\Filament\Resources\VrRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVrRooms extends ListRecords
{
    protected static string $resource = VrRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Ruang VR';
    }
}
