<?php

namespace App\Jobs;

use App\Enums\WalletType;
use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly array $user,
    )
    {
        //
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        try {
            DB::beginTransaction();
            User::create([
                'user_id' => $this->user['id'],
            ]);

            Wallet::create([
                'user_id' => $this->user['id'],
                'wallet_id' => Str::uuid(),
                'balance' => 0,
                'type' => WalletType::DEBIT,
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
