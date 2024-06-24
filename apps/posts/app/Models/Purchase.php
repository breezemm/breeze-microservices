<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'ticket_id',
        'qr_code',
    ];



    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }


    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }


}
