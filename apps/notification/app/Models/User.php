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
        'user-id',
        'tokens',
    ];


    public function notificationLists(): HasMany|\MongoDB\Laravel\Relations\HasMany
    {
        return $this->hasMany(NotificationList::class);
    }


}
