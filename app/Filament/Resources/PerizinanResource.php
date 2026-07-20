<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerizinanResource\Pages;
use App\Models\Perizinan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PerizinanResource extends Resource
{
    protected static ?string $model = Perizinan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $modelLabel = 'Perizinan';
    protected static ?string $navigationLabel = 'Perizinan';
    protected static ?string $navigationGroup = 'Anggota';
    protected static ?int $navigationSort = 4;

    public static function getBreadcrumb(): string
    {
        return 'Perizinan';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Pengguna')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->default(Auth::id())
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                Forms\Components\Select::make('jenis_izin')
                    ->label('Jenis Izin')
                    ->options([
                        'penelitian' => 'Izin Penelitian',
                        'kerja' => 'Izin Kerja',
                        'sakit' => 'Sakit',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                Forms\Components\DatePicker::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->afterOrEqual('tanggal_mulai'),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required(fn (string $operation, Forms\Get $get): bool => 
                        $operation === 'create' && in_array($get('jenis_izin'), ['penelitian', 'kerja']))
                    ->hidden(fn (Forms\Get $get) => $get('jenis_izin') === 'sakit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_izin')
                    ->label('Jenis Izin')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'penelitian' => 'Izin Penelitian',
                        'kerja' => 'Izin Kerja',
                        'sakit' => 'Sakit',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->label('Mulai')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Selesai')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan Pada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_izin')
                    ->options([
                        'penelitian' => 'Izin Penelitian',
                        'kerja' => 'Izin Kerja',
                        'sakit' => 'Sakit',
                    ])
                    ->label('Jenis Izin'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerizinans::route('/'),
            'view' => Pages\ViewPerizinan::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }
}
