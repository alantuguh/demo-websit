<?php

namespace App\Filament\Anggota\Resources\PerizinanResource\Pages;

use App\Filament\Anggota\Resources\PerizinanResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPerizinan extends ViewRecord
{
    protected static string $resource = PerizinanResource::class;

    public function getTitle(): string 
    {
        return 'Lihat Perizinan';
    }
}
