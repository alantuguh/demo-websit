<?php

namespace App\Filament\Resources\MuseSessionResource\Pages;

use App\Filament\Resources\MuseSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMuseSession extends EditRecord
{
    protected static string $resource = MuseSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
