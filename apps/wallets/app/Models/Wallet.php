<?php

namespace App\Models;

use Godruoyi\Snowflake\Snowflake;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'balance',
        'meta',
        'user_id',
        'deleted_at',
    ];

    protected $casts = [
        'meta' => 'json',
    ];


    /**
     * @throws BindingResolutionException
     */
    #[\Override]
    public static function boot(): void
    {
        parent::boot();

        $snowflake = app()->make(Snowflake::class);
        static::creating(function ($model) use ($snowflake) {
            $model->uuid = $snowflake->id();
        });
    }

}
