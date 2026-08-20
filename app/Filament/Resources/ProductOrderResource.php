<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductOrderResource\Pages;
use App\Models\ProductOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Pesanan yang masuk dari form halaman produk /toko/{slug}.
 * Pesanan dibuat pengunjung, bukan admin — halaman create dimatikan.
 */
class ProductOrderResource extends Resource
{
    protected static ?string $model = ProductOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationLabel = 'Toko — Pesanan';
    protected static ?string $modelLabel = 'Pesanan';
    protected static ?string $pluralModelLabel = 'Pesanan Toko';
    protected static ?string $navigationGroup = 'Manajemen Website';
    protected static ?int $navigationSort = 5;

    /**
     * Angka pesanan baru pada menu navigasi, supaya pesanan yang belum
     * ditindaklanjuti langsung terlihat begitu admin membuka panel.
     */
    public static function getNavigationBadge(): ?string
    {
        $baru = static::getModel()::baru()->count();

        return $baru > 0 ? (string) $baru : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tindak Lanjut')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Pesanan')
                            ->options(ProductOrder::statusOptions())
                            ->required(),
                    ]),

                Forms\Components\Section::make('Detail Pesanan')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Produk')
                            ->relationship('product', 'nama')
                            ->disabled(),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1),

                        Forms\Components\TextInput::make('harga_saat_pesan')
                            ->label('Harga Satuan Saat Pesan (Rp)')
                            ->numeric()
                            ->disabled(),

                        Forms\Components\TextInput::make('nama_pemesan')
                            ->label('Nama Pemesan'),

                        Forms\Components\TextInput::make('telepon')
                            ->label('Telepon / WhatsApp'),

                        Forms\Components\TextInput::make('email')
                            ->label('Email'),

                        Forms\Components\TextInput::make('instansi')
                            ->label('Instansi'),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan Pemesan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_pemesan')
                    ->label('Pemesan')
                    ->searchable()
                    ->description(fn (ProductOrder $record) => $record->instansi),

                Tables\Columns\TextColumn::make('product.nama')
                    ->label('Produk')
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jml'),

                Tables\Columns\TextColumn::make('telepon')
                    ->label('Telepon')
                    ->copyable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ProductOrder::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        'baru' => 'warning',
                        'dihubungi' => 'info',
                        'diproses' => 'primary',
                        'selesai' => 'success',
                        'batal' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(ProductOrder::statusOptions()),
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'nama'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Tindak Lanjuti'),
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
            'index' => Pages\ListProductOrders::route('/'),
            'edit' => Pages\EditProductOrder::route('/{record}/edit'),
        ];
    }
}
