<?php

namespace App\Filament\Resources\PrestasiKegiatanResource\Pages;

use App\Filament\Resources\PrestasiKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrestasiKegiatan extends EditRecord
{
    protected static string $resource = PrestasiKegiatanResource::class;

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
