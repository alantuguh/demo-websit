<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class ProyekLaboratorium extends Model
{
    use SoftDeletes;

    protected $table = 'proyek_laboratorium';

    protected $fillable = [
        'judul_proyek',
        'kategori',
        'deskripsi',
        'tahun',
        'mitra',
        'status',
        'gambar',
        'link_terkait',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = ['gambar_url'];

    /**
     * Daftar label kategori/program proyek yang tersedia, dipakai bersama
     * oleh form admin (Filament) maupun filter halaman publik.
     */
    public static function kategoriOptions(): array
    {
        return [
            'wibawa' => 'Wibawa',
            'jarpak' => 'Jarpak',
            'semesta' => 'Semesta',
            'dikti' => 'DIKTI',
            'kerjasama_uns' => 'Kerja Sama UNS',
        ];
    }

    /**
     * Daftar label status pelaksanaan proyek.
     */
    public static function statusOptions(): array
    {
        return [
            'berjalan' => 'Berjalan',
            'selesai' => 'Selesai',
        ];
    }

    /**
     * Get the gambar URL, fallback ke gambar default jika kosong.
     */
    protected function gambarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->gambar) {
                    return Storage::url($this->gambar);
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
     * Scope a query by kategori (wibawa, jarpak, semesta, dikti, kerjasama_uns).
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
