<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrestasiKegiatanResource\Pages;
use App\Filament\Resources\PrestasiKegiatanResource\RelationManagers;
use App\Models\PrestasiKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrestasiKegiatanResource extends Resource
{
    protected static ?string $model = PrestasiKegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Dokumentasi: Prestasi & Kegiatan';
    protected static ?string $modelLabel = 'Prestasi & Kegiatan';
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Dasar')
                            ->schema([
                                Forms\Components\TextInput::make('judul')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                
                                Forms\Components\Textarea::make('deskripsi')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Select::make('jenis')
                                    ->options([
                                        'prestasi' => 'Prestasi',
                                        'kegiatan' => 'Kegiatan',
                                    ])
                                    ->required()
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Toggle::make('is_video')
                                    ->label('Ini adalah video?')
                                    ->live()
                                    ->afterStateUpdated(fn ($state) => $state ? 'video' : 'gambar'),
                                    
                                Forms\Components\FileUpload::make('gambar')
                                    ->label('Gambar/Thumbnail')
                                    ->image()
                                    ->directory('prestasi-kegiatan')
                                    ->visibility('public')
                                    ->maxSize(2048)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('800')
                                    ->imageResizeTargetHeight('450')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->helperText('Format: JPG, PNG, atau WebP (Maks. 2MB). Disarankan rasio 16:9')
                                    ->hint('Gambar akan di-resize otomatis ke ukuran 800x450px')
                                    ->hidden(fn (Forms\Get $get) => $get('is_video')),
                                    
                                Forms\Components\TextInput::make('video_url')
                                    ->label('URL Video (YouTube/Vimeo)')
                                    ->url()
                                    ->required(fn (Forms\Get $get) => $get('is_video') === true)
                                    ->helperText('Contoh: https://www.youtube.com/watch?v=... atau https://vimeo.com/...')
                                    ->hint('Hanya mendukung YouTube dan Vimeo')
                                    ->hidden(fn (Forms\Get $get) => !$get('is_video')),
                                    
                                Forms\Components\DatePicker::make('tanggal')
                                    ->required()
                                    ->default(now()),
                                    
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(0),
                                    
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Tampilkan di Beranda')
                                    ->helperText('Maksimal 3 item yang bisa ditampilkan di beranda')
                                    ->default(false),
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
                    ->defaultImageUrl(fn ($record) => $record->is_video ? 'https://img.youtube.com/vi/' . $record->video_url . '/default.jpg' : '')
                    ->circular(),
                    
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'prestasi' => 'success',
                        'kegiatan' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_video')
                    ->label('Tipe')
                    ->icon(fn (bool $state): string => $state ? 'heroicon-s-video-camera' : 'heroicon-s-photo')
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),
                    
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
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
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'prestasi' => 'Prestasi',
                        'kegiatan' => 'Kegiatan',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('is_video')
                    ->label('Tipe Konten')
                    ->placeholder('Semua')
                    ->trueLabel('Video')
                    ->falseLabel('Gambar'),
                    
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
            'index' => Pages\ListPrestasiKegiatans::route('/'),
            'create' => Pages\CreatePrestasiKegiatan::route('/create'),
            'view' => Pages\ViewPrestasiKegiatan::route('/{record}'),
            'edit' => Pages\EditPrestasiKegiatan::route('/{record}/edit'),
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
