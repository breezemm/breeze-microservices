<?php

use App\Common\OTP;
use App\DataTransferObjects\PaymentData;
use App\DataTransferObjects\WalletData;
use App\Http\Integrations\Wallet\WalletAPI;
use Illuminate\Support\Facades\Route;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

$walletApi = new WalletAPI();

Route::get('/', function () {

    $producer = Kafka::publish()
        ->onTopic('wallets')
        ->withMessage(new Message(
            body: [
                'key' => 'bro',
            ]
        ));

    $producer->send(true);

    //    \App\Jobs\SendEmailVerificationOTPCodeJob::dispatch('aungmyatmoe834@gmail.com', '123456');

    return response()->json([
        'status' => 200,
        'message' => 'Gateway service is running.',
    ]);
});

Route::get('/health', function () {
    return response()->json([
        'status' => 200,
        'message' => 'Gateway service is healthy.',
    ]);
});

Route::get('/wallets', function () use ($walletApi) {
    $wallet = new WalletData(
        name: 'Prepaid',
        user_id: 1,
        currency: 'USD',
    );
    $response = $walletApi->wallets()->createWallet($wallet);

    return $response->json();
});

Route::get('/wallets/{id}', function ($id) use ($walletApi) {
    $walletApi = new WalletAPI();
    $response = $walletApi->wallets()->getWalletById(id: $id);

    return $response->json();
});

Route::get('/wallets/users/{id}', function (int $id) use ($walletApi) {
    $response = $walletApi->wallets()
        ->getWalletByUserId(id: $id);

    return $response->json();
});

Route::get('/payments', function (Request $request) use ($walletApi) {
    $paymentData = new PaymentData(
        senderWalletId: $request->input('sender_wallet_id'),
        receiverWalletId: $request->input('receiver_wallet_id'),
        amount: 100.00,
    );

    $response = $walletApi->payments()->createPaymentTransaction($paymentData);

    return $response->json();
});

Route::get('/otp', function () {
    $otp = new OTP();

    $otp->generate('aungmyatmoe834@gmail.com');

    return response()->json([
        'status' => 200,
        'message' => 'OTP generated successfully.',
    ]);
});
