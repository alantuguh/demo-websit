<?php

namespace App\Filament\Resources\ProyekLaboratoriumResource\Pages;

use App\Filament\Resources\ProyekLaboratoriumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProyekLaboratorium extends EditRecord
{
    protected static string $resource = ProyekLaboratoriumResource::class;

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
