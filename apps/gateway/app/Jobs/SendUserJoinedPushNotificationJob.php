<?php

namespace App\Jobs;

use App\Actions\SendPushNotification;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserJoinedPushNotificationJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Order $order)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        (new SendPushNotification())->handle([
            'notification_id' => 'event_joined',
            'user' => [
                'user_id' => $this->order->user_id,
            ],
            'channels' => [
                'push' => [
                    'title' => 'Join Event',
                    'body' => auth()->user()->name.' joins '.$this->order->event->name,
                    'data' => [
                        'type' => 'event_joined',
                        'user' => auth()->user()->load('media'),
                        'content' => 'joins',
                        'event' => $this->order->event,
                    ],
                ],
            ],
        ]);
    }
}
