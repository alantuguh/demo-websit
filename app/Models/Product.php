<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Produk komersial LPSKE yang tampil di halaman /toko.
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'deskripsi',
        'harga',
        'kelengkapan',
        'gambar',
        'galeri',
        'stok',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'harga' => 'integer',
        'kelengkapan' => 'array',
        'galeri' => 'array',
        'stok' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        // Slug dibuat otomatis dari nama bila kosong; diberi akhiran angka
        // bila sudah dipakai produk lain (termasuk yang terhapus lunak,
        // karena kolomnya unique di tingkat database).
        static::saving(function (Product $product) {
            if (blank($product->slug)) {
                $dasar = Str::slug($product->nama);
                $slug = $dasar;
                $n = 2;
                while (static::withTrashed()
                    ->where('slug', $slug)
                    ->when($product->exists, fn ($q) => $q->whereKeyNot($product->getKey()))
                    ->exists()) {
                    $slug = $dasar . '-' . $n++;
                }
                $product->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ProductOrder::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Harga terformat rupiah, mis. "Rp 40.000.000".
     */
    protected function hargaRupiah(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->harga, 0, ',', '.'),
        );
    }
}
