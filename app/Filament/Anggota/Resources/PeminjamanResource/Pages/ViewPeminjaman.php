<?php

namespace App\Filament\Anggota\Resources\PeminjamanResource\Pages;

use App\Filament\Anggota\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPeminjaman extends ViewRecord
{
    protected static string $resource = PeminjamanResource::class;

    public function getTitle(): string 
    {
        return 'Lihat Peminjaman';
    }
}
