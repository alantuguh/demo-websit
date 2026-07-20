<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryItemResource\Pages;
use App\Filament\Resources\InventoryItemResource\RelationManagers;
use App\Models\InventoryItem;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class InventoryItemResource extends Resource
{
    protected static ?string $model = InventoryItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $modelLabel = 'Barang';
    protected static ?string $navigationLabel = 'Manajemen Alat & Barang';
    protected static ?string $navigationGroup = 'Inventaris';
    protected static ?int $navigationSort = 1;

    public static function getBreadcrumb(): string
    {
        return 'Alat & Barang';
    }
    protected static function isAdmin(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && $user->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Barang')
                    ->schema([
                        Forms\Components\TextInput::make('nama_barang')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Barang'),
                        Forms\Components\TextInput::make('jumlah')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->label('Jumlah Total')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get, $operation) {
                                if ($operation === 'create') {
                                    $set('jumlah_tersedia', $state);
                                }
                            }),
                        Forms\Components\TextInput::make('jumlah_tersedia')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->label('Jumlah Tersedia')
                            ->default(fn ($operation) => $operation === 'create' ? null : 0)
                            ->disabled(fn ($operation) => $operation === 'edit')
                            ->helperText(fn ($operation) => $operation === 'edit' ? 'Tidak dapat diubah. Update stok melalui peminjaman.' : 'Jumlah barang yang tersedia untuk dipinjam')
                            ->dehydrated(fn ($operation) => $operation === 'create'),
                        
                        Forms\Components\Select::make('kondisi')
                            ->options([
                                'baik' => 'Baik',
                                'rusak_ringan' => 'Rusak Ringan',
                                'rusak_berat' => 'Rusak Berat',
                            ])
                            ->required()
                            ->label('Kondisi'),
                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_barang')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Barang'),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable()
                    ->label('Jumlah Total'),
                Tables\Columns\TextColumn::make('jumlah_tersedia')
                    ->numeric()
                    ->sortable()
                    ->label('Tersedia'),
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
                Tables\Columns\TextColumn::make('jumlah_tersedia')
                    ->numeric()
                    ->sortable()
                    ->label('Tersedia')
                    ->formatStateUsing(fn ($record) => "{$record->jumlah_tersedia} / {$record->jumlah}")
                    ->color(function ($record) {
                        if ($record->jumlah_tersedia <= 0) {
                            return 'danger';
                        }
                        
                        $percentage = ($record->jumlah_tersedia / $record->jumlah) * 100;
                        if ($percentage < 30) {
                            return 'danger';
                        } elseif ($percentage < 60) {
                            return 'warning';
                        }
                        
                        return 'success';
                    })
                    ->badge()
                    ->icon(fn ($record) => $record->jumlah_tersedia <= 0 ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->iconColor(fn ($record) => $record->jumlah_tersedia <= 0 ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kondisi')
                    ->options([
                        'baik' => 'Baik',
                        'rusak_ringan' => 'Rusak Ringan',
                        'rusak_berat' => 'Rusak Berat',
                    ])
                    ->label('Kondisi'),
                Tables\Filters\Filter::make('stok_habis')
                    ->query(fn (Builder $query): Builder => $query->where('jumlah_tersedia', '<=', 0))
                    ->label('Stok Habis'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'create' => Pages\CreateInventoryItem::route('/create'),
            'edit' => Pages\EditInventoryItem::route('/{record}/edit'),
        ];
    }
}