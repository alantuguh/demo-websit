<?php

namespace App\Filament\Anggota\Resources;

use App\Filament\Anggota\Resources\InventoryItemResource\Pages;
use App\Models\InventoryItem;
use App\Models\Peminjaman;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InventoryItemResource extends Resource
{
    protected static ?string $model = InventoryItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $modelLabel = 'Alat & Barang';
    protected static ?string $navigationLabel = 'Daftar Alat & Barang';
    protected static ?string $navigationGroup = 'Inventaris';
    protected static ?int $navigationSort = 1;

    public static function getBreadcrumb(): string
    {
        return 'Alat & Barang';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // No form needed for list view
            ]);
    }
    
    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_barang')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Barang'),
                
                Tables\Columns\TextColumn::make('jumlah_tersedia')
                    ->numeric()
                    ->sortable()
                    ->label('Tersedia')
                    ->color(function ($record) {
                        if ($record->jumlah_tersedia <= 0) {
                            return 'danger';
                        }
                        
                        $percentage = ($record->jumlah_tersedia / $record->jumlah) * 100;
                        if ($percentage < 30) {
                            return 'warning';
                        }
                        
                        return 'success';
                    }),
                
                Tables\Columns\TextColumn::make('kondisi')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'baik' => 'Baik',
                        'rusak_ringan' => 'Rusak Ringan',
                        'rusak_berat' => 'Rusak Berat',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'baik' => 'success',
                        'rusak_ringan' => 'warning',
                        'rusak_berat' => 'danger',
                    }),
                
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->keterangan),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kondisi')
                    ->options([
                        'baik' => 'Baik',
                        'rusak_ringan' => 'Rusak Ringan',
                        'rusak_berat' => 'Rusak Berat',
                    ])
                    ->label('Kondisi'),
                Tables\Filters\Filter::make('tersedia')
                    ->query(fn (Builder $query): Builder => $query->where('jumlah_tersedia', '>', 0))
                    ->label('Tersedia Saja')
            ])
            ->actions([
                Tables\Actions\Action::make('pinjam')
                    ->label('Pinjam')
                    ->icon('heroicon-o-hand-raised')
                    ->form([
                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(fn (InventoryItem $record) => $record->jumlah_tersedia)
                            ->default(1),
                        Forms\Components\DatePicker::make('tanggal_kembali')
                            ->label('Tanggal Kembali')
                            ->required()
                            ->minDate(now()),
                        Forms\Components\Textarea::make('alasan_pinjam')
                            ->label('Alasan Peminjaman')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->action(function (array $data, InventoryItem $record) {
                        // Create peminjaman record
                        Peminjaman::create([
                            'inventory_item_id' => $record->id,
                            'peminjam_id' => Auth::id(),
                            'jumlah' => $data['jumlah'],
                            'tanggal_pinjam' => now(),
                            'tanggal_kembali' => $data['tanggal_kembali'],
                            'alasan_pinjam' => $data['alasan_pinjam'],
                            'status' => 'menunggu',
                        ]);
                        
                        // No need to update available quantity here
                        // It will be updated when the item is returned
                    })
                    ->visible(fn (InventoryItem $record) => $record->jumlah_tersedia > 0)
                    ->disabled(fn (InventoryItem $record) => $record->jumlah_tersedia <= 0)
                    ->tooltip(fn (InventoryItem $record) => 
                        $record->jumlah_tersedia <= 0 ? 'Stok habis' : 'Ajukan peminjaman')
                    ->modalHeading('Ajukan Peminjaman')
                    ->modalSubmitActionLabel('Ajukan')
                    ->successNotificationTitle('Peminjaman berhasil diajukan!'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventoryItems::route('/'),
        ];
    }
}
