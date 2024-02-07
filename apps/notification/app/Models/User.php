<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Breeze\MongoDB\Auth\User as Authenticatable;


class User extends Authenticatable
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
        'settings', // Global settings for the user
    ];

    public function notificationTypes(): HasMany|\MongoDB\Laravel\Relations\HasMany
    {
        return $this->hasMany(NotificationType::class);
    }


}
