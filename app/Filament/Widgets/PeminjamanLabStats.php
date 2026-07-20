<?php

namespace App\Filament\Widgets;

use App\Models\PeminjamanLab;
use App\Filament\Resources\PeminjamanLabResource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PeminjamanLabStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Peminjaman', PeminjamanLab::count())
                ->description('Total pengajuan peminjaman lab')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),
                
            Stat::make('Menunggu', PeminjamanLab::where('status', 'menunggu')->count())
                ->description('Peminjaman menunggu persetujuan')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
                
            Stat::make('Disetujui', PeminjamanLab::where('status', 'disetujui')->count())
                ->description('Peminjaman yang disetujui')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
                
            Stat::make('Ditolak', PeminjamanLab::where('status', 'ditolak')->count())
                ->description('Peminjaman yang ditolak')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
    
    public static function canView(): bool
    {
        return PeminjamanLabResource::userIsAdmin();
    }
}
