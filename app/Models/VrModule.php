<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Satu modul (skenario latihan) VR di dalam sebuah ruang.
 */
class VrModule extends Model
{
    use SoftDeletes;

    protected $table = 'vr_modules';

    protected $fillable = [
        'vr_room_id',
        'judul',
        'deskripsi',
        'level',
        'status',
        'durasi_menit',
        'perangkat',
        'gambar',
        'video_url',
        'link_demo',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'durasi_menit' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $appends = ['gambar_url'];

    /**
     * Label tingkat kesulitan, dipakai bersama oleh form admin dan halaman publik.
     */
    public static function levelOptions(): array
    {
        return [
            'dasar' => 'Dasar',
            'menengah' => 'Menengah',
            'lanjut' => 'Lanjut',
        ];
    }

    /**
     * Label status ketersediaan modul.
     */
    public static function statusOptions(): array
    {
        return [
            'tersedia' => 'Tersedia',
            'pengembangan' => 'Dalam Pengembangan',
            'rencana' => 'Rencana',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(VrRoom::class, 'vr_room_id');
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
