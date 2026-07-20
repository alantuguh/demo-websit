<?php

namespace App\Filament\Anggota\Resources\PeminjamanResource\Pages;

use App\Filament\Anggota\Resources\PeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjaman extends ListRecords
{
    protected static string $resource = PeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    public function getTitle(): string 
    {
        return 'Peminjaman Saya';
    }
}
