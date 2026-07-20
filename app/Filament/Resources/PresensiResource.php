<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PresensiResource\Pages;
use App\Filament\Resources\PresensiResource\RelationManagers;
use App\Models\Presensi;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PresensiResource extends Resource
{
    protected static ?string $model = Presensi::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Presensi';
    protected static ?string $modelLabel = 'Presensi';
    protected static ?string $navigationGroup = 'Asisten';
    protected static ?int $navigationSort = 3;
    
    public static function canViewAny(): bool
    {
        return auth('admin')->check() || auth('asisten')->check();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('activity')
                    ->label('Aktivitas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('l, d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->label('Waktu')
                    ->time('H:i:s'),
                Tables\Columns\TextColumn::make('asisten.name')
                    ->label('Asisten')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('')
                    ->tooltip('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Presensi')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->form([
                        Forms\Components\TextInput::make('activity')
                            ->label('Aktivitas')
                            ->formatStateUsing(fn ($record) => $record->activity)
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->formatStateUsing(fn ($record) => $record->description)
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Fieldset::make('Informasi Waktu')
                            ->schema([
                                Forms\Components\TextInput::make('date')
                                    ->label('Tanggal')
                                    ->formatStateUsing(fn ($record) => $record->date ? \Carbon\Carbon::parse($record->date)->isoFormat('dddd, D MMMM YYYY') : null)
                                    ->disabled(),
                                Forms\Components\TextInput::make('time')
                                    ->label('Waktu')
                                    ->formatStateUsing(fn ($record) => $record->time ? \Carbon\Carbon::parse($record->time)->format('H:i:s') : null)
                                    ->disabled(),
                            ])->columns(2),
                        Forms\Components\TextInput::make('asisten.name')
                            ->label('Asisten')
                            ->formatStateUsing(fn ($record) => $record->asisten->name ?? '-')
                            ->disabled(),
                    ])
                    ->visible(fn (): bool => auth('admin')->check()),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->tooltip('Hapus Data')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Data Presensi')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data presensi ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->visible(fn (): bool => auth('admin')->check()),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListPresensis::route('/'),
            'view' => Pages\ViewPresensi::route('/{record}'),
        ];
    }
}
