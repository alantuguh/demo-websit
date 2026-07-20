<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanLabResource\Pages;
use App\Models\PeminjamanLab;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PeminjamanLabResource extends Resource
{
    protected static ?string $model = PeminjamanLab::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Manajemen Lab';
    protected static ?string $modelLabel = 'Peminjaman Lab';
    protected static ?string $navigationLabel = 'Peminjaman Lab';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('lab')
                    ->options([
                        'Lab Komputer 1' => 'Lab Komputer 1',
                        'Lab Komputer 2' => 'Lab Komputer 2',
                        'Lab Jaringan' => 'Lab Jaringan',
                        'Lab Multimedia' => 'Lab Multimedia',
                    ])
                    ->required()
                    ->label('Laboratorium'),
                Forms\Components\DateTimePicker::make('tanggal_pinjam')
                    ->required()
                    ->label('Tanggal Pinjam')
                    ->minDate(now()),
                Forms\Components\DateTimePicker::make('tanggal_selesai')
                    ->required()
                    ->label('Tanggal Selesai')
                    ->minDate(fn (callable $get) => $get('tanggal_pinjam')),
                Forms\Components\Textarea::make('tujuan')
                    ->required()
                    ->label('Tujuan Peminjaman')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('menunggu')
                    ->visible(fn (): bool => self::userIsAdmin()),
                Forms\Components\Textarea::make('catatan_admin')
                    ->label('Catatan Admin')
                    ->visible(fn (): bool => self::userIsAdmin())
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lab')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tujuan')
                    ->limit(30)
                    ->tooltip(fn (PeminjamanLab $record) => $record->tujuan),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Peminjam')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('lab')
                    ->options([
                        'Lab Komputer 1' => 'Lab Komputer 1',
                        'Lab Komputer 2' => 'Lab Komputer 2',
                        'Lab Jaringan' => 'Lab Jaringan',
                        'Lab Multimedia' => 'Lab Multimedia',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Setuju')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (PeminjamanLab $record): bool => 
                        self::userIsAdmin() && 
                        $record->status === 'menunggu'
                    )
                    ->action(function (PeminjamanLab $record) {
                        $record->update([
                            'status' => 'disetujui',
                            'disetujui_oleh' => Auth::id(),
                            'disetujui_pada' => now(),
                        ]);
                    })
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (PeminjamanLab $record): bool => 
                        self::userIsAdmin() && 
                        $record->status === 'menunggu'
                    )
                    ->form([
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Alasan Penolakan')
                            ->required(),
                    ])
                    ->action(function (PeminjamanLab $record, array $data) {
                        $record->update([
                            'status' => 'ditolak',
                            'catatan_admin' => $data['catatan_admin'],
                            'disetujui_oleh' => Auth::id(),
                            'disetujui_pada' => now(),
                        ]);
                    })
                    ->requiresConfirmation(),
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
        ];
    }

    /**
     * Check if the current user is an admin.
     * 
     * @return bool
     */
    public static function userIsAdmin(): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }
        
        // List of admin emails with access to admin features
        $adminEmails = [
            'admin@lpske.uns.ac.id',  // From database seeder
            // Add other admin emails as needed
        ];
        
        return in_array($user->email, $adminEmails);
    }

    public static function getEloquentQuery(): Builder
    {
        if (self::userIsAdmin()) {
            return parent::getEloquentQuery();
        }
        
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }
}
