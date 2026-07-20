<?php

namespace App\Filament\Resources\PerizinanResource\Pages;

use App\Filament\Resources\PerizinanResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPerizinan extends ViewRecord
{
    protected static string $resource = PerizinanResource::class;

    public function getTitle(): string 
    {
        return 'Lihat Perizinan';
    }
}
