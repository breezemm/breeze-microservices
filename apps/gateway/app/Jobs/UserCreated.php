<?php

namespace App\Jobs;

use App\Domains\Users\Actions\CreateWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\ArrayShape;

class UserCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        #[ArrayShape(['id' => 'mixed'])]
        public readonly array $user
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        (new CreateWallet)([
            'id' => $this->user['id'],
        ]);
    }
}