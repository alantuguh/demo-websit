<?php

namespace App\Filament\Widgets;

use App\Models\PeminjamanLab;
use App\Filament\Resources\PeminjamanLabResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RecentPeminjamanLabs extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Peminjaman Lab Terbaru';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                PeminjamanLab::query()
                    ->when(!PeminjamanLabResource::userIsAdmin(), function (Builder $query) {
                        return $query->where('user_id', Auth::id());
                    })
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('lab')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Tanggal Pinjam'),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Selesai'),
                Tables\Columns\TextColumn::make('tujuan')
                    ->limit(30)
                    ->tooltip(fn (PeminjamanLab $record) => $record->tujuan),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ]);
    }
    
    public static function canView(): bool
    {
        return true;
    }
}
