<?php

namespace App\Listeners;

use App\Events\WalletReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Purchased implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WalletReceived $event): void
    {
        \Log::info('Purchased',$event->data);
    }
}
