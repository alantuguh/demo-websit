<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Kelola produk yang dijual di halaman /toko.
 */
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Toko — Produk';
    protected static ?string $modelLabel = 'Produk Toko';
    protected static ?string $pluralModelLabel = 'Produk Toko';
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Produk')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (alamat halaman)')
                            ->helperText('Kosongkan untuk dibuat otomatis dari nama. Halaman produk: /toko/{slug}')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('kategori')
                            ->label('Kategori')
                            ->placeholder('mis. Simulator')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('harga')
                            ->label('Harga (Rupiah)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->minValue(0)
                            ->helperText('Angka utuh tanpa titik, mis. 40000000 untuk Rp 40.000.000'),

                        Forms\Components\TextInput::make('stok')
                            ->label('Stok')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Kosongkan bila produk dirakit sesuai pesanan (indent)'),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(5)
                            ->columnSpanFull(),

                        Forms\Components\TagsInput::make('kelengkapan')
                            ->label('Kelengkapan Paket')
                            ->placeholder('Ketik lalu tekan Enter, mis. "PC siap pakai"')
                            ->helperText('Daftar yang tampil sebagai "Termasuk dalam paket" di halaman produk')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Gambar')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar Utama')
                            ->image()
                            ->directory('toko')
                            ->visibility('public')
                            ->maxSize(3072)
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1200')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('JPG/PNG/WebP maks. 3MB; disarankan lanskap 16:9'),

                        Forms\Components\FileUpload::make('galeri')
                            ->label('Galeri Tambahan')
                            ->image()
                            ->multiple()
                            ->maxFiles(6)
                            ->directory('toko')
                            ->visibility('public')
                            ->maxSize(3072)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Sampai 6 foto pendukung (opsional)'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Penayangan')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Produk Unggulan')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif / Tampilkan di Toko')
                            ->default(true),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->square(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Produk')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->formatStateUsing(fn ($state) => $state ?? 'Indent')
                    ->placeholder('Indent'),

                Tables\Columns\TextColumn::make('orders_count')
                    ->label('Pesanan')
                    ->counts('orders')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
