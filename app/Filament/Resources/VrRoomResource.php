<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VrRoomResource\Pages;
use App\Models\VrRoom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class VrRoomResource extends Resource
{
    protected static ?string $model = VrRoom::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';
    protected static ?string $navigationLabel = 'VR: Ruang';
    protected static ?string $modelLabel = 'Ruang VR';
    protected static ?string $pluralModelLabel = 'Ruang VR';
    protected static ?string $navigationGroup = 'VR Ergonomy Lab';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Ruang')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Ruang')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            // Slug hanya diisi otomatis saat membuat data baru.
                            // Pada ruang yang sudah terbit, mengubah slug akan
                            // memutus tautan yang sudah tersebar.
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Dipakai pada alamat halaman: /vr-ergonomy/{slug}'),

                        Forms\Components\TextInput::make('tema')
                            ->label('Tema Singkat')
                            ->maxLength(255)
                            ->helperText('Satu frasa pendek, mis. "Pengukuran dimensi tubuh"')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Capaian Pembelajaran')
                    ->schema([
                        Forms\Components\Repeater::make('capaian')
                            ->label('Daftar Capaian')
                            ->simple(
                                Forms\Components\TextInput::make('butir')
                                    ->required()
                                    ->maxLength(255)
                            )
                            ->addActionLabel('Tambah capaian')
                            ->reorderable()
                            ->default([])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Tampilan')
                    ->schema([
                        Forms\Components\TextInput::make('ikon')
                            ->label('Ikon Font Awesome')
                            ->default('fa-vr-cardboard')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Tulis nama kelasnya saja, mis. fa-ruler-combined'),

                        Forms\Components\ColorPicker::make('warna')
                            ->label('Warna Aksen')
                            ->default('#2f5fe0')
                            ->required()
                            ->helperText('Dipakai untuk ikon dan garis atas kartu ruang'),

                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar Ruang (opsional)')
                            ->image()
                            ->directory('vr-rooms')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('960')
                            ->imageResizeTargetHeight('540')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif / Tampilkan di Website')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('warna')
                    ->label('Warna'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Ruang')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tema')
                    ->label('Tema')
                    ->limit(40)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('modules_count')
                    ->label('Jumlah Modul')
                    ->counts('modules')
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Tampil')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
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
            'index' => Pages\ListVrRooms::route('/'),
            'create' => Pages\CreateVrRoom::route('/create'),
            'view' => Pages\ViewVrRoom::route('/{record}'),
            'edit' => Pages\EditVrRoom::route('/{record}/edit'),
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
