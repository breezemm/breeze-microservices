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
        'post_id',
        'name',
        'start_date',
        'end_date',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

}
