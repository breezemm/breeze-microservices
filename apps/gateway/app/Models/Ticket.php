<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
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
    ];

    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }
}
