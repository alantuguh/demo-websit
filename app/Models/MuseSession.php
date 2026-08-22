<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Ringkasan satu sesi pemantauan di Muse Lab (/muse-lab).
 */
class MuseSession extends Model
{
    protected $fillable = [
        'nama_subjek',
        'aktivitas',
        'perangkat',
        'mode_demo',
        'mulai_pada',
        'durasi_detik',
        'ringkasan',
        'catatan',
    ];

    protected $casts = [
        'mode_demo' => 'boolean',
        'mulai_pada' => 'datetime',
        'durasi_detik' => 'integer',
        'ringkasan' => 'array',
    ];
}
