<?php

namespace App\Filament\Resources\VrModuleResource\Pages;

use App\Filament\Resources\VrModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVrModule extends EditRecord
{
    protected static string $resource = VrModuleResource::class;

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
