<?php

use Illuminate\Support\Facades\Route;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $message = new Message(body: createKafkaPayload(
        topic: 'wallets',
        pattern: [
            'cmd' => 'checkout',
        ],
        data: [
            'user_id' => 1,
        ],
    ));
    Kafka::publishOn('wallets.created')
        ->withMessage($message)
        ->send();

    return view('welcome');
});
