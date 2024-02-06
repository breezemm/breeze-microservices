<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class NotificationType extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'identifier',
    ];
}
