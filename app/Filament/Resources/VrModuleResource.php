<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VrModuleResource\Pages;
use App\Models\VrModule;
use App\Models\VrRoom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VrModuleResource extends Resource
{
    protected static ?string $model = VrModule::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'VR: Modul';
    protected static ?string $modelLabel = 'Modul VR';
    protected static ?string $pluralModelLabel = 'Modul VR';
    protected static ?string $navigationGroup = 'VR Ergonomy Lab';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Modul')
                    ->schema([
                        Forms\Components\Select::make('vr_room_id')
                            ->label('Ruang')
                            ->relationship('room', 'nama')
                            // Hanya ruang aktif yang ditawarkan agar modul baru
                            // tidak tersembunyi di ruang yang sudah dinonaktifkan.
                            ->options(fn () => VrRoom::active()->orderBy('sort_order')->pluck('nama', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Modul')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->maxLength(65535)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('level')
                            ->label('Tingkat')
                            ->options(VrModule::levelOptions())
                            ->default('dasar')
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status Ketersediaan')
                            ->options(VrModule::statusOptions())
                            ->default('rencana')
                            ->required()
                            ->helperText('Modul berstatus Rencana tetap tampil di katalog sebagai peta pengembangan.'),

                        Forms\Components\TextInput::make('durasi_menit')
                            ->label('Durasi (menit)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(600),

                        Forms\Components\TextInput::make('perangkat')
                            ->label('Perangkat')
                            ->maxLength(255)
                            ->helperText('Contoh: VR Headset, Desktop, VR Headset + Controller'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media & Tautan')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('vr-modules')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('video_url')
                            ->label('Tautan Video Cuplikan')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('link_demo')
                            ->label('Tautan Demo / Unduh')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Kosongkan bila modul belum bisa dijalankan.'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Tampilan')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tandai sebagai Unggulan')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif / Tampilkan di Website')
                            ->default(true),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Modul')
                    ->searchable()
                    ->sortable()
                    ->limit(45),

                Tables\Columns\TextColumn::make('room.nama')
                    ->label('Ruang')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tersedia' => 'success',
                        'pengembangan' => 'warning',
                        'rencana' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => VrModule::statusOptions()[$state] ?? $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('level')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => VrModule::levelOptions()[$state] ?? $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('durasi_menit')
                    ->label('Durasi')
                    ->suffix(' mnt')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Tampil')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('vr_room_id')
                    ->label('Ruang')
                    ->options(fn () => VrRoom::orderBy('sort_order')->pluck('nama', 'id')),

                Tables\Filters\SelectFilter::make('status')
                    ->options(VrModule::statusOptions()),

                Tables\Filters\SelectFilter::make('level')
                    ->options(VrModule::levelOptions()),

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
            'index' => Pages\ListVrModules::route('/'),
            'create' => Pages\CreateVrModule::route('/create'),
            'view' => Pages\ViewVrModule::route('/{record}'),
            'edit' => Pages\EditVrModule::route('/{record}/edit'),
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
