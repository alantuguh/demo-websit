<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'nip',
        'nim',
        'position',
        'study_program',
        'expertise',
        'email',
        'phone',
        'photo',
        'angkatan',
        'bio',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'angkatan' => 'integer',
        'sort_order' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeKepala($query)
    {
        return $query->type('kepala');
    }

    public function scopeDosen($query)
    {
        return $query->type('dosen');
    }

    public function scopeAsisten($query)
    {
        return $query->type('asisten');
    }

    /**
     * Get the URL to the team member's photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return null;
        }
        
        // If it's already a full URL, return as is
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }
        
        // Generate the URL using the asset helper
        $baseUrl = rtrim(config('app.url'), '/');
        $path = ltrim($this->photo, '/');
        return "{$baseUrl}/storage/teams/{$path}";
    }
}
