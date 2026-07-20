<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class InventoryItem extends Model
{
    protected $fillable = [
        'nama_barang',
        'jumlah',
        'jumlah_tersedia',
        'kondisi',
        'keterangan',
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            // Set jumlah_tersedia equal to jumlah when creating a new item
            if (empty($model->jumlah_tersedia)) {
                $model->jumlah_tersedia = $model->jumlah;
            }
        });
    }

    protected $casts = [
        'jumlah' => 'integer',
        'jumlah_tersedia' => 'integer',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
    
    public function peminjamanAktif()
    {
        return $this->hasMany(Peminjaman::class)
            ->whereIn('status', ['menunggu', 'disetujui']);
    }

    // Scope untuk barang yang tersedia (jumlah_tersedia > 0)
    public function scopeTersedia($query)
    {
        return $query->where('jumlah_tersedia', '>', 0);
    }

    // Scope untuk permintaan pinjaman yang menunggu persetujuan
    public function scopeMenungguPersetujuan($query)
    {
        return $query->where('status_persetujuan', 'menunggu');
    }
}
