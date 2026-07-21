<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class KaryaLab extends Model
{
    use SoftDeletes;

    protected $table = 'karya_lab';

    protected $fillable = [
        'nama_karya',
        'kategori',
        'deskripsi',
        'tahun',
        'tim_penulis',
        'file_gambar',
        'link_publikasi',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = ['file_gambar_url'];

    /**
     * Daftar label kategori yang tersedia, dipakai bersama
     * oleh form admin (Filament) maupun filter halaman publik.
     */
    public static function kategoriOptions(): array
    {
        return [
            'penelitian' => 'Penelitian',
            'produk' => 'Produk',
            'publikasi' => 'Publikasi',
            'prototipe' => 'Prototipe',
        ];
    }

    /**
     * Get the file/gambar URL, fallback ke gambar default jika kosong.
     */
    protected function fileGambarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->file_gambar) {
                    return Storage::url($this->file_gambar);
                }
                return asset('images/default-image.jpg');
            },
        );
    }

    /**
     * Scope a query to only include active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured items.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query by kategori (penelitian, produk, publikasi, prototipe).
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
