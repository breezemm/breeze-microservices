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
        'information',
        'price',
        'is_has_seating_plan',
        'total_seats',
    ];

    public function phase(): BelongsTo
    {
        return $this->belongsTo(Phase::class);
    }
}
