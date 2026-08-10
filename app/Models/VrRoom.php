<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Satu ruang tematik di dalam VR Ergonomy Lab.
 */
class VrRoom extends Model
{
    use SoftDeletes;

    protected $table = 'vr_rooms';

    protected $fillable = [
        'nama',
        'slug',
        'tema',
        'deskripsi',
        'capaian',
        'ikon',
        'warna',
        'gambar',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'capaian' => 'array',
        'is_active' => 'boolean',
    ];

    protected $appends = ['gambar_url'];

    /**
     * Ruang dirujuk lewat slug pada URL /vr-ergonomy/{slug}, bukan lewat id.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function modules(): HasMany
    {
        return $this->hasMany(VrModule::class)->orderBy('sort_order');
    }

    /**
     * Modul yang tampil di halaman publik.
     */
    public function activeModules(): HasMany
    {
        return $this->modules()->where('is_active', true);
    }

    protected function gambarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->gambar ? Storage::url($this->gambar) : null,
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
