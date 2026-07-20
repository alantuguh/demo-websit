<?php

namespace App\Filament\Resources\AsistenAkunResource\Pages;

use App\Filament\Resources\AsistenAkunResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsisten extends EditRecord
{
    protected static string $resource = AsistenAkunResource::class;

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