<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketType extends Model
{
    use HasFactory;

    protected $fillable = [
        'phase_id',
        'name',
        'benefits',
        'price',
        'is_has_seating_plan',
        'total_seats',
    ];

    protected $casts = [
        'benefits' => 'array',
        'is_has_seating_plan' => 'boolean',
    ];


    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'ticket_type_id', 'id');
    }
}
