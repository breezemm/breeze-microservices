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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class WalletCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        #[ArrayShape([
            'id' => "int",
        ])]
        public readonly array $user,
    )
    {
        //
    }

    /**
     * @throws \Exception
     */
    public function handle(WalletService $walletService): void
    {
        $walletService->create([
            'user_id' => $this->user['id'],
        ]);
    }
}
