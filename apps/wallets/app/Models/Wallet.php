<?php

namespace App\Models;

use App\Enums\WalletType;
use Cknow\Money\Casts\MoneyDecimalCast;
use Cknow\Money\Money;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Money|null $balance
 */
class Wallet extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'balance',
        'meta',
        'currency',
        'user_id',
        'qr_code',
        'type',
        'deleted_at',
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
            $model->qr_code = $snowflake->id();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function scopeFindByUuid(Builder $query, string $uuid): Builder
    {
        return $query->where('uuid', $uuid);
    }

    public function scopeFindByQrCode(Builder $query, string $qrCode): Builder
    {
        return $query->where('qr_code', $qrCode);
    }

    public function withdraw(Money $amount): self
    {
        $this->balance = $this->balance->subtract($amount);
        $this->save();

        return $this;
    }

    public function deposit(Money $amount): self
    {
        $this->balance = $this->balance->add($amount);
        $this->save();

        return $this;
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'type' => WalletType::class,
            'balance' => MoneyDecimalCast::class,
        ];
    }
}
