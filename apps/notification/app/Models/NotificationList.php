<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use App\Enums\NotificationType;
use App\Enums\NotificationChannel;

final class NotificationList extends Model
{

    protected $fillable = [
        'user_id',
    ];

    protected $casts = [
        'type' => NotificationType::class,
        'channel' => NotificationChannel::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
