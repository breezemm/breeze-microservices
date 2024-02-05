<?php

use App\Models\User;
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
    User::create([
        'user_id' => 1,
        'notification_settings' => 'all',
        'hey' => 'hey',
    ]);

    return view('welcome');
});


Route::get('/push', function () {
    $message = new Message(body: [
        'user_id' => 4,
        'pattern' => 'wallets.failed',
    ]);
    Kafka::publishOn('wallets')
        ->withMessage($message)
        ->send();
    return 'Message sent';
});
