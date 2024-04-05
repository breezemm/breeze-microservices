<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimePassword extends Model
{
    protected $fillable = [
        'identifier',
        'otp',
        'status',
        'expires_at',
    ];
}
