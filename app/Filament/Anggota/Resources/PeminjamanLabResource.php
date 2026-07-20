<?php

namespace App\Filament\Anggota\Resources;

use App\Filament\Anggota\Resources\PeminjamanLabResource\Pages;
use App\Models\PeminjamanLab;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class PeminjamanLabResource extends Resource
{
    protected static ?string $model = PeminjamanLab::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Laboratorium';
    protected static ?string $modelLabel = 'Peminjaman Lab';
    protected static ?string $navigationLabel = 'Peminjaman Lab';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Form Peminjaman Lab')
                    ->description('Isi form berikut untuk mengajukan peminjaman lab')
                    ->schema([
                        Forms\Components\Hidden::make('lab')
                            ->default('Laboratorium LPSKE')
                            ->required(),
                            
                        Forms\Components\Placeholder::make('lab_info')
                            ->label('Laboratorium LPSKE')
                            ->columnSpanFull(),
                            
                        Forms\Components\DateTimePicker::make('tanggal_pinjam')
                            ->required()
                            ->label('Tanggal Mulai')
                            ->minDate(now())
                            ->native(false)
                            ->displayFormat('d M Y H:i')
                            ->closeOnDateSelection()
                            ->seconds(false)
                            ->minutesStep(30)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('tanggal_selesai', null);
                            }),
                            
                        Forms\Components\DateTimePicker::make('tanggal_selesai')
                            ->required()
                            ->label('Tanggal Selesai')
                            ->minDate(fn (callable $get) => $get('tanggal_pinjam') ? \Carbon\Carbon::parse($get('tanggal_pinjam'))->addHour() : now())
                            ->native(false)
                            ->displayFormat('d M Y H:i')
                            ->closeOnDateSelection()
                            ->seconds(false)
                            ->minutesStep(30),
                            
                        Forms\Components\Textarea::make('tujuan')
                            ->required()
                            ->label('Tujuan Peminjaman')
                            ->placeholder('Contoh: Praktikum Jaringan Komputer')
                            ->columnSpanFull(),
                            
                        Forms\Components\Hidden::make('status')
                            ->default('menunggu'),
                            
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn () => Auth::id()),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lab')
                    ->label('Laboratorium')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('tujuan')
                    ->limit(30)
                    ->tooltip(fn (PeminjamanLab $record) => $record->tujuan),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('catatan_admin')
                    ->label('Catatan')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('')
                    ->tooltip('Lihat Detail')
                    ->icon('heroicon-o-eye'),
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->tooltip('Edit')
                    ->icon('heroicon-o-pencil')
                    ->visible(fn (PeminjamanLab $record): bool => 
                        $record->status === 'menunggu' && 
                        $record->user_id === Auth::id()
                    ),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->tooltip('Hapus')
                    ->icon('heroicon-o-trash')
                    ->visible(fn (PeminjamanLab $record): bool => 
                        $record->status === 'menunggu' && 
                        $record->user_id === Auth::id()
                    ),
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
            'index' => Pages\ListPeminjamanLabs::route('/'),
            'create' => Pages\CreatePeminjamanLab::route('/create'),
            'view' => Pages\ViewPeminjamanLab::route('/{record}'),
            'edit' => Pages\EditPeminjamanLab::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id())
            ->latest();
    }
}
