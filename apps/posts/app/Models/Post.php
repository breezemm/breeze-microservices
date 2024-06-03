<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'place',
        'description',
        'is_has_phases',
    ];

    protected $casts = [
        'is_has_phases' => 'boolean',
    ];


    public function phases(): HasMany
    {
        return $this->hasMany(Phase::class);
    }

}
