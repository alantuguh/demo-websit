<?php

namespace App\Filament\Resources\AlumniStoryResource\Pages;

use App\Filament\Resources\AlumniStoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlumniStory extends EditRecord
{
    protected static string $resource = AlumniStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
