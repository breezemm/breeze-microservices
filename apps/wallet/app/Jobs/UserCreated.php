<?php

namespace App\Jobs;

use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JetBrains\PhpStorm\ArrayShape;

class UserCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
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
    public function handle(UserService $userService): void
    {
        $userService->create([
            'user_id' => $this->user['id'],
        ]);
    }
}
