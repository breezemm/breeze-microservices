<?php

namespace App\Jobs;

use App\Enums\WalletType;
use App\Models\User;
use App\Models\Wallet;
use App\Services\UserService;
use App\Services\WalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class WalletCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly int $user_id,
    )
    {
        //
    }

    /**
     * @throws \Exception
     */
    public function handle(WalletService $walletService): void
    {
        User::create([
            'user_id' => $this->user_id,
        ]);
        $walletService->create([
            'user_id' => $this->user_id,
        ]);
    }
}
