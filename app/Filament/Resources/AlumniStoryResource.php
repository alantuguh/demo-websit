<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniStoryResource\Pages;
use App\Filament\Resources\AlumniStoryResource\RelationManagers;
use App\Models\AlumniStory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AlumniStoryResource extends Resource
{
    protected static ?string $model = AlumniStory::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Alumni Story';
    protected static ?string $modelLabel = 'Alumni Story';
    protected static ?string $pluralModelLabel = 'Alumni Stories';
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Foto')
                    ->description('Unggah foto untuk ditampilkan di halaman Alumni Story')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->label('')
                            ->image()
                            ->directory('alumni')
                            ->imageEditor()
                            ->columnSpanFull()
                            ->maxSize(2048)
                            ->helperText('Ukuran maksimal 2MB. Format: JPG, JPEG, atau PNG')
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Informasi')
                    ->schema([
                        Forms\Components\Select::make('angkatan')
                            ->label('Angkatan')
                            ->options(function () {
                                $currentYear = (int) date('Y');
                                $years = [];
                                for ($year = $currentYear; $year >= 2010; $year--) {
                                    $years[$year] = $year;
                                }
                                return $years;
                            })
                            ->required()
                            ->default(date('Y'))
                            ->columnSpan(1),
                        
                        Forms\Components\RichEditor::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Tampilkan di Halaman Utama')
                            ->helperText('Aktifkan untuk menampilkan di halaman utama')
                            ->required()
                            ->default(true),
                    ])
                    ->collapsible()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png'))
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('testimoni')
                    ->limit(30)
                    ->searchable()
                    ->label('Konten'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Aktif'),
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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAlumniStory::route('/'),
            'create' => Pages\CreateAlumniStory::route('/create'),
            'edit' => Pages\EditAlumniStory::route('/{record}/edit'),
        ];
    }
}
