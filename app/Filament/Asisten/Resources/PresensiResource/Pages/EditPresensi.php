<?php

namespace App\Filament\Asisten\Resources\PresensiResource\Pages;

use App\Filament\Asisten\Resources\PresensiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPresensi extends EditRecord
{
    protected static string $resource = PresensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
