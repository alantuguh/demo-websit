<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Presensi extends Model
{
    protected $fillable = [
        'activity',
        'description',
        'date',
        'time',
        'asisten_id',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($presensi) {
            // Set default asisten_id if not provided
            if (auth('asisten')->check()) {
                $presensi->asisten_id = auth('asisten')->id();
            } elseif (!$presensi->asisten_id) {
                // If no asisten is authenticated and no asisten_id is provided, use the first available asisten
                $asisten = User::where('role', 'asisten')->first();
                if ($asisten) {
                    $presensi->asisten_id = $asisten->id;
                }
            }
            
            // Set default date and time if not provided
            $now = now('Asia/Jakarta'); // Set timezone to WIB (Jakarta)
            
            // If date is not set, use current date in WIB
            if (empty($presensi->date)) {
                $presensi->date = $now->toDateString();
            }
            
            // If time is not set, use current time in WIB
            if (empty($presensi->time)) {
                $presensi->time = $now->format('H:i:s');
            }
        });
    }

    /**
     * Get the asisten that owns the presensi.
     */
    public function asisten(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asisten_id');
    }
}
