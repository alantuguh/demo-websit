<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MuseSessionResource\Pages;
use App\Models\MuseSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Arsip sesi pemantauan Muse Lab. Sesi dibuat dari halaman publik /muse-lab
 * (dikirim browser setelah rekaman selesai) — admin hanya membaca, memberi
 * catatan, atau menghapus; halaman create dimatikan.
 */
class MuseSessionResource extends Resource
{
    protected static ?string $model = MuseSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationLabel = 'Sesi Muse Lab';
    protected static ?string $modelLabel = 'Sesi Muse Lab';
    protected static ?string $pluralModelLabel = 'Sesi Muse Lab';
    protected static ?string $navigationGroup = 'Manajemen Lab';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Sesi')
                    ->schema([
                        Forms\Components\TextInput::make('nama_subjek')
                            ->label('Nama Subjek'),

                        Forms\Components\TextInput::make('aktivitas')
                            ->label('Aktivitas'),

                        Forms\Components\TextInput::make('perangkat')
                            ->label('Perangkat')
                            ->disabled(),

                        Forms\Components\Toggle::make('mode_demo')
                            ->label('Mode Demo (tanpa headband)')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('mulai_pada')
                            ->label('Mulai')
                            ->disabled(),

                        Forms\Components\TextInput::make('durasi_detik')
                            ->label('Durasi (detik)')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Hasil')
                    ->schema([
                        // Ringkasan JSON hanya untuk dibaca; strukturnya
                        // disusun aplikasi dan tidak diedit dari panel.
                        Forms\Components\Textarea::make('ringkasan')
                            ->label('Ringkasan Metrik (JSON)')
                            ->rows(16)
                            ->disabled()
                            ->dehydrated(false)
                            ->formatStateUsing(fn ($state) => json_encode(
                                is_string($state) ? json_decode($state, true) : $state,
                                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                            )),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mulai_pada')
                    ->label('Waktu Sesi')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_subjek')
                    ->label('Subjek')
                    ->searchable()
                    ->description(fn (MuseSession $record) => $record->aktivitas),

                Tables\Columns\TextColumn::make('durasi_detik')
                    ->label('Durasi')
                    ->formatStateUsing(function (int $state) {
                        // Label eksplisit "jam/mnt/dtk", bukan singkatan satu
                        // huruf ala gmdate — "d" gampang terbaca "hari".
                        $jam = intdiv($state, 3600);
                        $menit = intdiv($state % 3600, 60);
                        $detik = $state % 60;
                        $bagian = [];
                        if ($jam > 0) $bagian[] = $jam . ' jam';
                        if ($jam > 0 || $menit > 0) $bagian[] = $menit . ' mnt';
                        $bagian[] = $detik . ' dtk';
                        return implode(' ', $bagian);
                    }),

                Tables\Columns\TextColumn::make('perangkat')
                    ->label('Perangkat')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('mode_demo')
                    ->label('Demo')
                    ->boolean(),
            ])
            ->defaultSort('mulai_pada', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('mode_demo')->label('Mode Demo'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Lihat / Catat'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMuseSessions::route('/'),
            'edit' => Pages\EditMuseSession::route('/{record}/edit'),
        ];
    }
}
