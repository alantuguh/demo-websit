<?php

namespace App\Filament\Resources\AlumniStoryResource\Pages;

use App\Filament\Resources\AlumniStoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlumniStory extends ListRecords
{
    protected static string $resource = AlumniStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
