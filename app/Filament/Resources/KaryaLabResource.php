<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryaLabResource\Pages;
use App\Models\KaryaLab;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KaryaLabResource extends Resource
{
    protected static ?string $model = KaryaLab::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Katalog Produk & Karya';
    protected static ?string $modelLabel = 'Karya Laboratorium';
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Dasar')
                            ->schema([
                                Forms\Components\TextInput::make('nama_karya')
                                    ->label('Nama Karya')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('deskripsi')
                                    ->label('Deskripsi')
                                    ->maxLength(65535)
                                    ->rows(4)
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('kategori')
                                    ->label('Kategori')
                                    ->options(KaryaLab::kategoriOptions())
                                    ->required(),

                                Forms\Components\TextInput::make('tahun')
                                    ->label('Tahun')
                                    ->numeric()
                                    ->minValue(2000)
                                    ->maxValue((int) date('Y') + 1)
                                    ->default(date('Y'))
                                    ->required(),

                                Forms\Components\TextInput::make('tim_penulis')
                                    ->label('Tim Penulis')
                                    ->maxLength(255)
                                    ->helperText('Pisahkan lebih dari satu nama dengan tanda koma')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('link_publikasi')
                                    ->label('Tautan Publikasi')
                                    ->url()
                                    ->maxLength(255)
                                    ->helperText('Tautan menuju publikasi/produk terkait (opsional)')
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('file_gambar')
                                    ->label('Gambar/Thumbnail')
                                    ->image()
                                    ->directory('katalog-karya')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('800')
                                    ->imageResizeTargetHeight('450')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->helperText('Format: JPG, PNG, atau WebP (Maks. 2MB). Disarankan rasio 16:9')
                                    ->hint('Gambar akan di-resize otomatis ke ukuran 800x450px')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Tampilkan sebagai Unggulan')
                                    ->default(false),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif / Tampilkan di Website')
                                    ->default(true),
                            ])
                            ->columns(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_gambar')
                    ->label('Thumbnail')
                    ->circular(),

                Tables\Columns\TextColumn::make('nama_karya')
                    ->label('Nama Karya')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'penelitian' => 'success',
                        'produk' => 'info',
                        'publikasi' => 'warning',
                        'prototipe' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => KaryaLab::kategoriOptions()[$state] ?? $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tim_penulis')
                    ->label('Tim Penulis')
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options(KaryaLab::kategoriOptions()),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Unggulan')
                    ->placeholder('Semua')
                    ->trueLabel('Unggulan')
                    ->falseLabel('Bukan Unggulan'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListKaryaLabs::route('/'),
            'create' => Pages\CreateKaryaLab::route('/create'),
            'view' => Pages\ViewKaryaLab::route('/{record}'),
            'edit' => Pages\EditKaryaLab::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
