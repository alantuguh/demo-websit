<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlumniStory extends Model
{
    use SoftDeletes;

    protected $table = 'alumni_story';

    protected $fillable = [
        'deskripsi',
        'foto',
        'angkatan',
        'is_active',
        'user_id'
    ];
    
    protected $casts = [
        'angkatan' => 'integer',
        'is_active' => 'boolean',
    ];
}
