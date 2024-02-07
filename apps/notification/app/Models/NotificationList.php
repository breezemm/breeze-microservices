<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;

class NotificationList extends Model
{
    protected $fillable = [
        'user_id', // The ID of the user in your system. Required.
        'message',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo|\MongoDB\Laravel\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function notificationType(): \Illuminate\Database\Eloquent\Relations\BelongsTo|\MongoDB\Laravel\Relations\BelongsTo
    {
        return $this->belongsTo(NotificationType::class);
    }
}
