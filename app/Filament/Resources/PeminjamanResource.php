<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $modelLabel = 'Peminjaman';
    protected static ?string $modelLabelPlural = 'Peminjaman';
    protected static ?string $navigationLabel = 'Manajemen Peminjaman';
    protected static ?string $navigationGroup = 'Inventaris';
    protected static ?int $navigationSort = 2;
    
    public static function getSlug(): string
    {
        return 'peminjaman';
    }
    
    public static function getBreadcrumb(): string
    {
        return 'Peminjaman';
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
                Forms\Components\Section::make('Informasi Peminjaman')
                    ->schema([
                        Forms\Components\Select::make('inventory_item_id')
                            ->relationship('inventoryItem', 'nama_barang')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Barang')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $item = \App\Models\InventoryItem::find($state);
                                if ($item) {
                                    $set('jumlah', 1);
                                    $set('jumlah_tersedia', $item->jumlah_tersedia);
                                }
                            }),
                        
                        Forms\Components\Select::make('peminjam_id')
                            ->relationship('peminjam', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(fn () => Auth::id())
                            ->label('Peminjam')
                            ->disabled(fn () => !self::isAdmin()),
                        
                        Forms\Components\TextInput::make('jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->label('Jumlah Dipinjam')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $max = $get('jumlah_tersedia');
                                if ($state > $max) {
                                    $set('jumlah', $max);
                                }
                            }),
                        
                        Forms\Components\Hidden::make('jumlah_tersedia'),
                        
                        Forms\Components\DateTimePicker::make('tanggal_pinjam')
                            ->default(now())
                            ->required()
                            ->label('Tanggal Pinjam'),
                        
                        Forms\Components\DateTimePicker::make('tanggal_kembali')
                            ->required()
                            ->label('Tanggal Kembali')
                            ->after('tanggal_pinjam'),
                        
                        Forms\Components\Textarea::make('alasan_pinjam')
                            ->required()
                            ->label('Alasan Peminjaman')
                            ->columnSpanFull(),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'menunggu' => 'Menunggu',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                                'dikembalikan' => 'Dikembalikan',
                                'terlambat' => 'Terlambat',
                            ])
                            ->default('menunggu')
                            ->required()
                            ->label('Status')
                            ->visible(fn () => self::isAdmin()),
                        
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin')
                            ->columnSpanFull()
                            ->visible(fn () => self::isAdmin()),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                static::getModel()::query()
                    ->with(['inventoryItem', 'peminjam'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('inventoryItem.nama_barang')
                    ->searchable()
                    ->sortable()
                    ->label('Barang'),
                
                Tables\Columns\TextColumn::make('peminjam.name')
                    ->searchable()
                    ->sortable()
                    ->label('Peminjam'),
                
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable()
                    ->label('Jumlah'),
                
                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal Pinjam'),
                
                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal Kembali'),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'menunggu' => 'Menunggu Persetujuan',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'dikembalikan' => 'Sudah Dikembalikan',
                        'terlambat' => 'Terlambat',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        'dikembalikan' => 'info',
                        'terlambat' => 'danger',
                    })
                    ->label('Status'),
                
                Tables\Columns\TextColumn::make('alasan_pinjam')
                    ->label('Alasan Peminjaman')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->alasan_pinjam),
                
                Tables\Columns\TextColumn::make('catatan_admin')
                    ->label('Catatan Admin')
                    ->toggleable(isToggledHiddenByDefault: true),
                
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu Persetujuan',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'dikembalikan' => 'Sudah Dikembalikan',
                        'terlambat' => 'Terlambat',
                    ])
                    ->label('Status'),
                
                Tables\Filters\Filter::make('terlambat')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'terlambat'))
                    ->label('Hanya Terlambat'),
                    
                Tables\Filters\Filter::make('belum_dikembalikan')
                    ->query(fn (Builder $query): Builder => $query->whereIn('status', ['menunggu', 'disetujui', 'terlambat']))
                    ->label('Belum Dikembalikan')
                    ->default(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (Peminjaman $record) {
                        // Update status peminjaman - stock akan diupdate otomatis oleh model's updating event
                        $record->update([
                            'status' => 'disetujui',
                        ]);
                    })
                    ->visible(fn (Peminjaman $record): bool => 
                        $record->status === 'menunggu' && 
                        self::isAdmin()
                    ),
                
                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Peminjaman')
                    ->form([
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->placeholder('Masukkan alasan penolakan peminjaman...'),
                    ])
                    ->action(function (array $data, Peminjaman $record) {
                        $record->update([
                            'status' => 'ditolak',
                            'catatan_admin' => $data['catatan_admin'],
                        ]);
                    })
                    ->visible(fn (Peminjaman $record): bool => 
                        $record->status === 'menunggu' && 
                        self::isAdmin()
                    ),
                
                Tables\Actions\Action::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan Barang')
                    ->form([
                        Forms\Components\TextInput::make('jumlah_kembali')
                            ->label('Jumlah Dikembalikan')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(fn (Peminjaman $record) => $record->jumlah)
                            ->default(fn (Peminjaman $record) => $record->jumlah),
                        
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Pengembalian')
                            ->placeholder('Masukkan catatan pengembalian barang...'),
                    ])
                    ->action(function (array $data, Peminjaman $record) {
                        // Update status, jumlah dikembalikan, dan tanggal pengembalian
                        $record->update([
                            'status' => 'dikembalikan',
                            'jumlah' => $data['jumlah_kembali'], // Update jumlah yang dikembalikan
                            'tanggal_pengembalian' => now(),
                            'catatan_admin' => $data['catatan_admin'] ?? $record->catatan_admin,
                        ]);
                        
                        // Stock akan diupdate otomatis oleh model's updating event
                    })
                    ->visible(fn (Peminjaman $record): bool => 
                        $record->status === 'disetujui' && 
                        self::isAdmin()
                    ),
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
            'index' => Pages\ListPeminjaman::route('/'),
            'view' => Pages\ViewPeminjaman::route('/{record}'),
        ];
    }
    

    public static function canCreate(): bool
    {
        return false;
    }
    
    public static function canEdit($record): bool
    {
        return false;
    }
}
