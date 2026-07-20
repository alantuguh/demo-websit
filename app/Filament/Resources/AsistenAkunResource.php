<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsistenAkunResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AsistenAkunResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Kelola Akun';
    protected static ?string $navigationLabel = 'Asisten';
    protected static ?string $modelLabel = 'Akun Asisten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : '')
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->revealable()
                    ->label('Password')
                    ->confirmed(),
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->label('Konfirmasi Password')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->dehydrated(false),
                Forms\Components\Hidden::make('role')
                    ->default('asisten'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Terverifikasi Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Belum terverifikasi'),
                Tables\Columns\TextColumn::make('password')
                    ->getStateUsing(fn () => '••••••••')
                    ->label('Password')
                    ->copyable()
                    ->copyMessage('Password disalin ke clipboard')
                    ->copyMessageDuration(1500)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->disabled(),
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->default(fn ($record) => '••••••••')
                            ->password()
                            ->revealable()
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function ($component, $state, $record) {
                                if ($record) {
                                    $component->state($record->getOriginal('password'));
                                }
                            }),
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAsisten::route('/'),
            'create' => Pages\CreateAsisten::route('/create'),
            'edit' => Pages\EditAsisten::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('role', 'asisten')->count();
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('role', 'asisten')
            ->orderBy('created_at', 'desc');
    }

    public static function create(Form $form, array $data = []): Model
    {
        $data['email_verified_at'] = now();
        $data['role'] = 'asisten';
        
        $user = static::getModel()::create($data);
        
        return $user;
    }

    public static function update(Form $form, Model $record, array $data): Model
    {
        $data['role'] = 'asisten';
        $record->update($data);
        
        return $record;
    }
}
