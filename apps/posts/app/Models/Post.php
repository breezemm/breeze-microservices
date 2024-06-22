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
        'date',
        'start_time',
        'end_time',
        'address',
        'city',
        'description',
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }


    protected function casts(): array
    {
        return [
            'is_has_phases' => 'boolean',
        ];
    }


    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }


}
