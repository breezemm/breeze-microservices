<?php

use Illuminate\Support\Facades\Route;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

Route::get('/push', function () {
    $message = new Message(
        body: createKafkaPayload(
        topic: 'wallets',
        pattern: 'wallets.created',
        data: [
            'user_id' => 'Hello',
        ],
    ));
    Kafka::publishOn('wallets')
        ->withMessage($message)
        ->send();

    return 'Pushed';
});
