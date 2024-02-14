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

class SendUserJoinedPushNotificationJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private Order $order)
    {
        //
    }

    /**
     * Execute the job.
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
                    'body' => auth()->user()->name . ' joins ' . $this->order->event->name . ' event.',
                    'data' => [
                        'type' => 'event_joined',
                        'user' => auth()->user()->with('media')->get(),
                        'content' => 'joins',
                        'event' => $this->order->event,
                    ]
                ]
            ],
        ]);
    }
}
