<?php

namespace App\Models;

use App\Enums\WalletType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory;


    protected $fillable = [
        'wallet_id',
        'user_id',
        'balance',
        'currency',
        'type',
        'qr_code',
    ];


    protected $casts = [
        'balance' => 'float',
        'type' => WalletType::class,
        'currency' => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
