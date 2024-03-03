<?php

namespace App\Models;

use App\Enums\CurrencyType;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'transaction_type',
        'transaction_amount',
        'transaction_currency',
        'transaction_description',
        'sender_wallet_id',
        'receiver_wallet_id',
    ];

    protected $casts = [
        'transaction_amount' => 'float',
        'transaction_type' => TransactionType::class,
        'transaction_currency' => CurrencyType::class,
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user');
    }

}