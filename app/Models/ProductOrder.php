<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Pesanan produk dari form halaman /toko/{slug}.
 */
class ProductOrder extends Model
{
    protected $fillable = [
        'product_id',
        'nama_pemesan',
        'telepon',
        'email',
        'instansi',
        'alamat',
        'jumlah',
        'catatan',
        'harga_saat_pesan',
        'status',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_saat_pesan' => 'integer',
    ];

    public static function statusOptions(): array
    {
        return [
            'baru' => 'Baru',
            'dihubungi' => 'Sudah Dihubungi',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'batal' => 'Batal',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }
}
