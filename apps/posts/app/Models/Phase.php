<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'ticket_type_id',
        'name',
        'start_date',
        'end_date',
        'price',
    ];


    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'price' => 'float',
        ];
    }

    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }



}
