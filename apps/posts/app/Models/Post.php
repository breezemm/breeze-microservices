<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
            'has_saved' => 'boolean',
        ];
    }


    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }


    public function saves(): HasMany
    {
        return $this->hasMany(SavedPost::class);
    }



    protected function hasSaved(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => $this->where('user_id', auth()->id())->exists(),
            set: fn($value) => $value,
        );
    }
}
