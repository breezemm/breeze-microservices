<?php

namespace App\Models;

use App\Enums\WalletType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;


    protected $guarded = [];
    protected $casts = [
        'balance' => 'float',
        'type' => WalletType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
