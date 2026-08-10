<?php

namespace App\Filament\Resources\AsistenAkunResource\Pages;

use App\Filament\Resources\AsistenAkunResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAsisten extends CreateRecord
{
    protected static string $resource = AsistenAkunResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
