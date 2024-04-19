<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OneTimePassword extends Model
{

    protected $fillable = [
        'identifier',
        'otp',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
