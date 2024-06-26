<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasSnowflakePrimary;

class Follow extends Model
{
    use HasFactory, HasSnowflakePrimary;

    protected $fillable = [
        'follower_id',
        'following_id',
        'blocked',
    ];


}
