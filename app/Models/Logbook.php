<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Logbook extends Model
{
    protected $table = 'logbooks';
    
    protected $fillable = [
        'activity',
        'description',
        'date',
        'asisten_id',
    ];
    
    protected static function booted()
    {
        static::creating(function ($logbook) {
            if (auth('asisten')->check()) {
                $logbook->asisten_id = auth('asisten')->id();
            }
        });
    }
    
    public function asisten()
    {
        return $this->belongsTo(\App\Models\User::class, 'asisten_id')->withDefault([
            'name' => 'Admin',
        ]);
    }
    
    public function scopeRecent($query)
    {
        return $query->where('date', '>=', now()->subDay())
                   ->orderBy('date', 'desc')
                   ->first();
    }

    protected $casts = [
        'date' => 'datetime',
    ];
}
