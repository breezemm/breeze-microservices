<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\Model;

class User extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'notification_settings',
        'email',
        'email',
        'phone_number',
        'push_tokens',
        'web_push_tokens',
    ];


    public function notificationTypes(): HasMany|\MongoDB\Laravel\Relations\HasMany
    {
        return $this->hasMany(NotificationType::class, 'user_id', 'user_id');
    }

    public function notificationLists(): HasMany|\MongoDB\Laravel\Relations\HasMany
    {
        return $this->hasMany(NotificationList::class, 'user_id', 'user_id');
    }


}
