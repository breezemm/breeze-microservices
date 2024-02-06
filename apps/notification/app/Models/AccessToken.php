<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;

class AccessToken extends Model
{
    protected $fillable = [
        'user_id',
        'environment',
        'client_id',
        'client_secret',
        'expires_at',
    ];
}
