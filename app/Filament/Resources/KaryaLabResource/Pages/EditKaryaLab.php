<?php

namespace App\Filament\Resources\KaryaLabResource\Pages;

use App\Filament\Resources\KaryaLabResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKaryaLab extends EditRecord
{
    protected static string $resource = KaryaLabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
