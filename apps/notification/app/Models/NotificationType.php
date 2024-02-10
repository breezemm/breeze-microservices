<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class NotificationType extends Model
{
    protected $fillable = [
        'user_id', // The ID of the user in your system. Required.
        'notification_id',
        'settings',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notificationLists(): HasMany
    {
        return $this->hasMany(NotificationList::class);
    }

}
