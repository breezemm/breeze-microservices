<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CityList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }
}
