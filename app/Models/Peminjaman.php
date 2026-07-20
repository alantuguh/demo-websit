<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    
    protected $fillable = [
        'inventory_item_id',
        'peminjam_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_pengembalian',
        'alasan_pinjam',
        'catatan_admin',
        'status'
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        static::updating(function ($model) {
            $originalStatus = $model->getOriginal('status');
            $newStatus = $model->status;
            
            // When status changes to 'disetujui', decrease available stock
            if ($originalStatus !== 'disetujui' && $newStatus === 'disetujui') {
                $model->inventoryItem->decrement('jumlah_tersedia', $model->jumlah);
            }
            
            // When status changes from 'disetujui' to something else (except 'dikembalikan'), return stock
            if ($originalStatus === 'disetujui' && $newStatus !== 'dikembalikan' && $newStatus !== 'disetujui') {
                $model->inventoryItem->increment('jumlah_tersedia', $model->jumlah);
            }
            
            // When status changes to 'dikembalikan', return the stock
            if ($newStatus === 'dikembalikan' && $originalStatus !== 'dikembalikan') {
                // Only increment if it was previously approved
                if ($originalStatus === 'disetujui') {
                    $model->inventoryItem->increment('jumlah_tersedia', $model->jumlah);
                }
                $model->tanggal_pengembalian = now();
            }
        });
    }

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_pengembalian' => 'datetime',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }
    
    // Scopes
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }
    
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }
    
    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }
    
    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'dikembalikan');
    }
    
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'terlambat');
    }
}
