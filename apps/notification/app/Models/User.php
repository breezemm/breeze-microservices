<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\Model;


class User extends Model
{
    use  Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id', // The ID of the user in your system. Required.
        'email',
        'phone_number',
        'push_tokens',
        'web_push_tokens',
        'settings', // Global settings for the user, high priority.
    ];

    public function notificationTypes(): HasMany|\MongoDB\Laravel\Relations\HasMany
    {
        return $this->hasMany(NotificationType::class);
    }


    public function routeNotificationForFcm(): array|string
    {
        return collect($this->push_tokens)
            ->filter(fn($pushToken) => $pushToken['type'] === 'FCM')
            ->map(fn($pushToken) => $pushToken['token']);
    }

}
