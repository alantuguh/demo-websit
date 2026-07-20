<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Http\UploadedFile as TemporaryUploadedFile;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?string $modelLabel = 'Anggota Tim';
    protected static ?string $navigationLabel = 'Tim';
    protected static ?int $navigationSort = 1;

    public static function getBreadcrumb(): string
    {
        return 'Anggota Tim';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Kategori Anggota')
                    ->tabs([
                        Tab::make('Informasi Dasar')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Section::make()
                                            ->schema([
                                                Select::make('type')
                                                    ->label('Jabatan')
                                                    ->options([
                                                        'kepala' => 'Kepala Laboratorium',
                                                        'dosen' => 'Dosen Laboratorium',
                                                        'asisten' => 'Asisten Laboratorium',
                                                        'anggota' => 'Anggota',
                                                    ])
                                                    ->required()
                                                    ->reactive(),
                                                TextInput::make('name')
                                                    ->label('Nama Lengkap')
                                                    ->required(),
                                                TextInput::make('nip')
                                                    ->label('NIP')
                                                    ->visible(fn (callable $get) => in_array($get('type'), ['kepala', 'dosen'])),
                                                TextInput::make('nim')
                                                    ->label('NIM')
                                                    ->visible(fn (callable $get) => $get('type') === 'asisten'),
                                                TextInput::make('angkatan')
                                                    ->label('Angkatan')
                                                    ->numeric()
                                                    ->visible(fn (callable $get) => in_array($get('type'), ['asisten', 'anggota'])),

                                                TextInput::make('study_program')
                                                    ->label('Program Studi')
                                                    ->visible(fn (callable $get) => $get('type') === 'asisten'),
                                                TextInput::make('expertise')
                                                    ->label('Bidang Keahlian')
                                                    ->visible(fn (callable $get) => in_array($get('type'), ['kepala', 'dosen'])),
                                            ]),
                                        Section::make('Kontak')
                                            ->schema([
                                                TextInput::make('email')
                                                    ->label('Email')
                                                    ->email(),
                                                TextInput::make('phone')
                                                    ->label('Nomor Telepon/WA'),
                                            ]),
                                    ]),
                                Section::make('Foto Profil')
                                    ->schema([
                                        FileUpload::make('photo')
                                            ->label('Foto Profil')
                                            ->image()
                                            ->directory('teams')
                                            ->imageEditor()
                                            ->imagePreviewHeight('250')
                                            ->getUploadedFileNameForStorageUsing(
                                                function (TemporaryUploadedFile $file): string {
                                                    $extension = $file->getClientOriginalExtension();
                                                    $filename = time() . '-' . uniqid() . '.' . $extension;
                                                    return $filename;
                                                }
                                            )
                                            ->hint('Kosongkan jika tidak ingin mengubah foto')
                                            ->hintIcon('heroicon-o-information-circle')
                                    ]),
                                Section::make('Tentang')
                                    ->schema([
                                        RichEditor::make('bio')
                                            ->label('Biografi')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_url')
                    ->label('Foto')
                    ->circular()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->width(50)
                    ->height(50),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Jabatan')
                    ->formatStateUsing(function (string $state): string {
                        $states = [
                            'kepala' => 'Kepala Laboratorium',
                            'dosen' => 'Dosen Laboratorium',
                            'asisten' => 'Asisten Laboratorium'
                        ];
                        return $states[$state] ?? $state;
                    })
                    ->badge()
                    ->color(function (string $state): string {
                        $colors = [
                            'kepala' => 'danger',
                            'dosen' => 'primary',
                            'asisten' => 'success'
                        ];
                        return $colors[$state] ?? 'gray';
                    }),
                TextColumn::make('angkatan')
                    ->label('Angkatan')
                    ->visibleFrom('md')
                    ->toggleable(true, true),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(true, true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Anggota')
                    ->options([
                        'kepala' => 'Kepala Laboratorium',
                        'dosen' => 'Dosen',
                        'asisten' => 'Asisten',
                    ]),
                Tables\Filters\Filter::make('angkatan')
                    ->form([
                        Forms\Components\Select::make('angkatan')
                            ->label('Angkatan')
                            ->options([
                                '2018' => '2018',
                                '2019' => '2019',
                                '2020' => '2020',
                                '2021' => '2021',
                                '2022' => '2022',
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['angkatan'],
                            fn (Builder $query, $angkatan): Builder => $query->where('angkatan', $angkatan),
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('type', 'desc')
            ->defaultSort('name', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
