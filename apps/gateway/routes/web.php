<?php

use App\DataTransferObjects\PaymentData;
use App\DataTransferObjects\WalletData;
use App\Http\Integrations\Wallet\Requests\Payments\CreatePaymentTransaction;
use App\Http\Integrations\Wallet\Requests\Wallets\CreateWallet;
use App\Http\Integrations\Wallet\Requests\Wallets\GetWalletById;
use App\Http\Integrations\Wallet\Requests\Wallets\GetWalletByUserId;
use App\Http\Integrations\Wallet\WalletAPI;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 200,
        'message' => 'Gateway service is healthy.',
    ]);
});

Route::get('/wallets', function () {
    $wallet = new WalletAPI();
    $response = $wallet->send(
        new CreateWallet(
            new WalletData(
                name: 'Prepaid',
                user_id: 1,
                currency: 'USD',
            ))
    );

    return $response->json();
});

Route::get('/wallets/{id}', function ($id) {
    $wallet = new WalletAPI();
    $response = $wallet->send(
        new GetWalletById(
            id: $id
        )
    );

    return $response->json();
});

Route::get('/wallets/users/{id}', function ($id) {
    $wallet = new WalletAPI();
    $response = $wallet->send(
        new GetWalletByUserId(
            id: $id
        )
    );

    return $response->json();
});

Route::get('/payments', function (Request $request) {
    $wallet = new WalletAPI();

    $response = $wallet->send(
        new CreatePaymentTransaction(
            new PaymentData(
                senderWalletId: $request->input('sender_wallet_id'),
                receiverWalletId: $request->input('receiver_wallet_id'),
                amount: 100,
            )
        )
    );

    return $response->json();
});

Route::get('/test', function () {
    $walletApi = new WalletAPI();
    $walletApi->wallets()->getWalletById(id: 1);
    $walletApi->wallets()->createWallet(
        new WalletData(
            name: 'Prepaid',
            user_id: 1,
            currency: 'USD',
        )
    );
});
