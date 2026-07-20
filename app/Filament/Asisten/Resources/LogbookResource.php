<?php

namespace App\Filament\Asisten\Resources;

use App\Filament\Asisten\Resources\LogbookResource\Pages;
use App\Filament\Asisten\Resources\LogbookResource\RelationManagers;
use App\Models\Logbook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogbookResource extends Resource
{
    protected static ?string $model = Logbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $modelLabel = 'Logbook';
    protected static ?string $navigationLabel = 'Logbooks';
    protected static ?int $navigationSort = 1;
    protected static bool $shouldRegisterNavigation = true; // Show in navigation

    public static function form(Form $form): Form
    {
        $isAsisten = auth('asisten')->check();
        
        return $form
            ->schema([
                Forms\Components\TextInput::make('activity')
                    ->label('Aktivitas')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->default(now())
                    ->disabled($isAsisten)
                    ->dehydrated(),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                // Hidden field to store asisten_id if not already set
                Forms\Components\Hidden::make('asisten_id')
                    ->default(fn () => auth('asisten')->id())
                    ->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $isAsisten = auth('asisten')->check();
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('activity')
                    ->label('Aktivitas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
    
    public static function canViewAny(): bool
    {
        return auth('admin')->check() || auth('asisten')->check();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogbooks::route('/'),
            'create' => Pages\CreateLogbook::route('/create'),
            'edit' => Pages\EditLogbook::route('/{record}/edit'),
        ];
    }
}
