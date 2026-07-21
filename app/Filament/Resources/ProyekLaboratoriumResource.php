<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyekLaboratoriumResource\Pages;
use App\Models\ProyekLaboratorium;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProyekLaboratoriumResource extends Resource
{
    protected static ?string $model = ProyekLaboratorium::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationLabel = 'Proyek Laboratorium';
    protected static ?string $modelLabel = 'Proyek Laboratorium';
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Dasar')
                            ->schema([
                                Forms\Components\TextInput::make('judul_proyek')
                                    ->label('Judul Proyek')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('deskripsi')
                                    ->label('Deskripsi')
                                    ->maxLength(65535)
                                    ->rows(4)
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('kategori')
                                    ->label('Kategori Program')
                                    ->options(ProyekLaboratorium::kategoriOptions())
                                    ->required(),

                                Forms\Components\Select::make('status')
                                    ->label('Status Pelaksanaan')
                                    ->options(ProyekLaboratorium::statusOptions())
                                    ->default('berjalan')
                                    ->required(),

                                Forms\Components\TextInput::make('tahun')
                                    ->label('Tahun')
                                    ->numeric()
                                    ->minValue(2000)
                                    ->maxValue((int) date('Y') + 1)
                                    ->default(date('Y'))
                                    ->required(),

                                Forms\Components\TextInput::make('mitra')
                                    ->label('Mitra/Instansi')
                                    ->maxLength(255)
                                    ->helperText('Contoh: Kemendikbudristek, Universitas Sebelas Maret, dsb.')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('link_terkait')
                                    ->label('Tautan Terkait')
                                    ->url()
                                    ->maxLength(255)
                                    ->helperText('Tautan menuju informasi lebih lanjut tentang proyek (opsional)')
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('gambar')
                                    ->label('Gambar/Thumbnail')
                                    ->image()
                                    ->directory('proyek-laboratorium')
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
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Thumbnail')
                    ->circular(),

                Tables\Columns\TextColumn::make('judul_proyek')
                    ->label('Judul Proyek')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'wibawa' => 'success',
                        'jarpak' => 'info',
                        'semesta' => 'warning',
                        'dikti' => 'danger',
                        'kerjasama_uns' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ProyekLaboratorium::kategoriOptions()[$state] ?? $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'selesai' ? 'success' : 'warning')
                    ->formatStateUsing(fn (string $state): string => ProyekLaboratorium::statusOptions()[$state] ?? $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('mitra')
                    ->label('Mitra/Instansi')
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status Tampil')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options(ProyekLaboratorium::kategoriOptions()),

                Tables\Filters\SelectFilter::make('status')
                    ->options(ProyekLaboratorium::statusOptions()),

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
            'index' => Pages\ListProyekLaboratoriums::route('/'),
            'create' => Pages\CreateProyekLaboratorium::route('/create'),
            'view' => Pages\ViewProyekLaboratorium::route('/{record}'),
            'edit' => Pages\EditProyekLaboratorium::route('/{record}/edit'),
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
