<?php

namespace App\Filament\Anggota\Resources\PerizinanResource\Pages;

use App\Filament\Anggota\Resources\PerizinanResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePerizinan extends CreateRecord
{
    protected static string $resource = PerizinanResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }
}
