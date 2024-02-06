<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class NotificationType extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'notification_type_id',
        'description',
        'settings',
    ];


    public function user(): BelongsTo|\MongoDB\Laravel\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }


    public function notificationLists(): HasMany|\MongoDB\Laravel\Relations\HasMany
    {
        return $this->hasMany(NotificationList::class);
    }
}

