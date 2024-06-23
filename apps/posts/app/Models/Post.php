<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'name',
        'date',
        'start_time',
        'end_time',
        'address',
        'city',
        'description',
        'interests',
        'terms',
    ];

    protected function casts(): array
    {
        return [
            'is_has_phases' => 'boolean',
            'interests' => 'json',
            'terms' => 'boolean',
        ];
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }


    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }


}
