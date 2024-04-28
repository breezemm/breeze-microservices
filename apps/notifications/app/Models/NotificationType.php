<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationType extends Model
{
    protected $fillable = [
        'notification_id',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function notificationLists(): HasMany
    {
        return $this->hasMany(NotificationList::class);
    }
}
