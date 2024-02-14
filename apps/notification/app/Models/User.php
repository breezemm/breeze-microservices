<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'notification_settings',
        'email',
        'phone_number',
        'push_tokens',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'push_tokens' => 'array',
    ];



    public function notificationTypes(): HasMany
    {
        return $this->hasMany(NotificationType::class);
    }

}
