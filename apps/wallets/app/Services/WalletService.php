<?php

namespace App\Services;

use App\Contracts\WalletServiceInterface;
use App\DataTransferObjects\WalletData;
use App\Enums\TransactionType;
use App\Enums\WalletType;
use App\Exceptions\InsufficientFundException;
use App\Exceptions\WalletCreationFailed;
use App\Models\Transaction;
use App\Models\Wallet;
use Cknow\Money\Money;
use Illuminate\Support\Facades\DB;

final readonly class WalletService implements WalletServiceInterface
{
    public function __construct(
        public AtomicLockService $atomicLockService,
    ) {
    }

    /**
     * @throws WalletCreationFailed
     */
    public function create(WalletData $createWalletDTO): void
    {
        try {
            DB::beginTransaction();

            $wallet = [
                ...$createWalletDTO->all(),
                'type' => WalletType::PREPAID,
            ];

            Wallet::create($wallet);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new WalletCreationFailed();
        }

    }

    /**
     * @throws InsufficientFundException If the wallet has insufficient fund
     * @throws \Exception
     * @throws \Throwable
     */
    public function transfer(Wallet $from, Wallet $to, Money $amount, ?array $meta = null): Wallet
    {
        throw_if($from->balance->lessThan($amount), new InsufficientFundException());

        try {
            DB::beginTransaction();

            // Block the wallets to prevent the concurrent transaction at once from the same wallet in the same time
            $this->atomicLockService->blocks([$from, $to], function () use ($from, $to, $amount, $meta) {
                $this->withdraw($from, $amount)
                    ->transactions()
                    ->create([
                        'amount' => $amount->getAmount(),
                        'type' => TransactionType::WITHDRAW,
                        'wallet_id' => $to->id,
                        'meta' => $meta,
                    ]);

                $this->deposit($to, $amount)
                    ->transactions()
                    ->create([
                        'amount' => $amount->getAmount(),
                        'type' => TransactionType::DEPOSIT,
                        'wallet_id' => $from->id,
                        'meta' => $meta,
                    ]);
            });

            DB::commit();

            return $from;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function withdraw(Wallet $wallet, Money $amount): ?Wallet
    {
        return $wallet->withdraw($amount);
    }

    public function deposit(Wallet $wallet, Money $amount): ?Wallet
    {
        return $wallet->deposit($amount);
    }

    public function delete(Wallet $wallet): void
    {
        $wallet->delete();
    }
}
