<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaAkunResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class AnggotaAkunResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Kelola Akun';
    protected static ?string $navigationLabel = 'Anggota';
    protected static ?string $modelLabel = 'Akun Anggota';

    public static function form(Form $form): Form
    {
        $isCreate = $form->getOperation() === 'create';
        
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
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
                        
                        // Only show these fields on create
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label('Password')
                            ->revealable()
                            ->maxLength(255)
                            ->required($isCreate)
                            ->visible($isCreate)
                            ->dehydrateStateUsing(function ($state, $get, $set, $record) use ($isCreate) {
                                if (empty($state)) {
                                    return $isCreate ? null : $record?->password;
                                }
                                
                                // Always store the encrypted password for admin
                                if ($record) {
                                    $record->encrypted_password_storage = encrypt($state);
                                    $record->save();
                                }
                                
                                return Hash::make($state);
                            })
                            ->dehydrated(fn ($state) => filled($state) || $isCreate),
                            
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->label('Konfirmasi Password')
                            ->required($isCreate)
                            ->visible($isCreate)
                            ->maxLength(255)
                            ->dehydrated(false)
                            ->same('password')
                            ->helperText('Ketik ulang password Anda'),
                    ]),

                // Only show password update section on edit
                Forms\Components\Section::make('Ubah Password')
                    ->description('Isi untuk mengubah password')
                    ->visible(fn () => !$isCreate)
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label('Password Baru')
                            ->revealable()
                            ->maxLength(255)
                            ->live()
                            ->helperText('Biarkan kosong jika tidak ingin mengubah password')
                            ->dehydrateStateUsing(function ($state, $get, $set, $record) {
                                if (empty($state)) {
                                    return $record?->password;
                                }
                                
                                // Store both hashed and encrypted password
                                if ($record) {
                                    $record->update([
                                        'password' => Hash::make($state),
                                        'encrypted_password_storage' => encrypt($state)
                                    ]);
                                }
                                
                                return $record?->password ?? Hash::make($state);
                            })
                            ->dehydrated(fn ($state) => filled($state)),
                            
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->label('Konfirmasi Password Baru')
                            ->maxLength(255)
                            ->dehydrated(false)
                            ->visible(fn ($get) => !empty($get('password')))
                            ->same('password')
                            ->helperText(function ($get) {
                                return !empty($get('password')) 
                                    ? 'Ketik ulang password baru Anda' 
                                    : '';
                            }),
                    ]),
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
                Tables\Columns\IconColumn::make('has_stored_password')
                    ->label('Password Tersimpan')
                    ->getStateUsing(fn ($record) => !empty($record->encrypted_password_storage))
                    ->boolean()
                    ->trueIcon('heroicon-o-lock-closed')
                    ->falseIcon('heroicon-o-lock-open')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Terverifikasi Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->email_verified_at 
                            ? $record->email_verified_at->format('d/m/Y H:i')
                            : null;
                    })
                    ->placeholder('Belum terverifikasi')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->label('Email Terverifikasi'),
                Tables\Filters\Filter::make('has_stored_password')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('encrypted_password_storage'))
                    ->label('Memiliki Password Tersimpan'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('password_display')
                            ->label('Password')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Forms\Set $set, $record) {
                                try {
                                    $password = !empty($record->encrypted_password_storage) 
                                        ? decrypt($record->encrypted_password_storage) 
                                        : 'Tidak ada password tersimpan';
                                    $set('password_display', $password);
                                } catch (\Exception $e) {
                                    $set('password_display', 'Tidak dapat menampilkan password');
                                }
                            }),
                    ]),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * Generate secure password
     */
    private static function generateSecurePassword(): string
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*';
        
        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];
        
        $allChars = $uppercase . $lowercase . $numbers . $symbols;
        for ($i = 4; $i < 12; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }
        
        return str_shuffle($password);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnggotas::route('/'),
            'create' => Pages\CreateAnggota::route('/create'),
            'edit' => Pages\EditAnggota::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('role', 'anggota')->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('role', 'anggota')
            ->orderBy('created_at', 'desc');
    }
}