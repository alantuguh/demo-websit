<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class PrestasiKegiatan extends Model
{
    use SoftDeletes;

    protected $table = 'prestasi_kegiatan';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'video_url',
        'jenis',
        'tanggal',
        'is_video',
        'is_featured',
        'featured_at',
        'is_active',
        'sort_order'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->is_featured) {
                // Jika menandai sebagai featured, set featured_at ke waktu sekarang
                $model->featured_at = now();
                
                // Cek apakah sudah ada 3 item yang difiturkan
                $featuredCount = self::where('is_featured', true)
                    ->where('id', '!=', $model->id)
                    ->count();
                    
                if ($featuredCount >= 3) {
                    // Jika sudah ada 3, cari yang paling lama difiturkan dan nonaktifkan
                    $oldestFeatured = self::where('is_featured', true)
                        ->where('id', '!=', $model->id)
                        ->orderBy('featured_at')
                        ->first();
                        
                    if ($oldestFeatured) {
                        $oldestFeatured->update([
                            'is_featured' => false,
                            'featured_at' => null
                        ]);
                    }
                }
            } else {
                // Jika tidak difiturkan, hapus featured_at
                $model->featured_at = null;
            }
        });
    }

    protected $casts = [
        'tanggal' => 'date',
        'is_video' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'featured_at' => 'datetime',
    ];

    protected $appends = ['gambar_url'];

    /**
     * Get the gambar URL.
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
        return $query->where('is_featured', true)
                    ->orderBy('featured_at', 'desc');
    }

    /**
     * Scope a query by jenis (prestasi or kegiatan).
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }
}
