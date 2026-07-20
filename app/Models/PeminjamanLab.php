<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeminjamanLab extends Model
{
    protected $table = 'peminjaman_lab';
    
    protected $fillable = [
        'user_id',
        'lab',
        'tanggal_pinjam',
        'tanggal_selesai',
        'tujuan',
        'status',
        'catatan_admin',
        'disetujui_oleh',
        'disetujui_pada'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'disetujui_pada' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function disetujuiOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
