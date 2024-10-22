<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Glorand\Model\Settings\Traits\HasSettingsField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelLike\Traits\Liker;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Followable;
    use Follower;
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasRoles;
    use HasSettingsField;
    use InteractsWithMedia;
    use Liker;
    use Notifiable;

    public $defaultSettings = [
        'bio' => '',
        'social_links' => [
            'facebook' => '',
            'telegram' => '',
            'instagram' => '',
            'tiktok' => '',
            'snapchat' => '',
            'website' => '',
        ],
        'language' => 'en',

    ];

    public $settingsRules = [
        'social_links' => 'array',
        'social_links.facebook' => 'url',
        'social_links.telegram' => 'url',
        'social_links.instagram' => 'url',
        'social_links.tiktok' => 'url',
        'social_links.snapchat' => 'url',
        'social_links.website' => 'url',
        'language' => 'string|in:en,my',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'pronoun',
        'username',
        'gender',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'accept_terms' => 'boolean',
    ];

    public function scopeWhereUsername(Builder $query, string $username): void
    {
        $query->where('username', $username);
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function launchedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
