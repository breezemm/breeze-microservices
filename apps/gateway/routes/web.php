<?php

use App\DataTransferObjects\WalletData;
use App\Http\Integrations\Wallet\Requests\Wallets\CreateWalletRequest;
use App\Http\Integrations\Wallet\Requests\Wallets\GetWalletByIdRequest;
use App\Http\Integrations\Wallet\Requests\Wallets\GetWalletByUserIdRequest;
use App\Http\Integrations\Wallet\WalletConnector;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 200,
        'message' => 'Gateway service is healthy.',
    ]);
});

Route::get('/wallets', function () {
    $wallet = new WalletConnector();
    $response = $wallet->send(
        new CreateWalletRequest(
            new WalletData(
                name: 'Prepaid',
                user_id: 1,
                currency: 'USD',
            ))
    );

    return $response->json();
});

Route::get('/wallets/{id}', function ($id) {
    $wallet = new WalletConnector();
    $response = $wallet->send(
        new GetWalletByIdRequest(
            id: $id
        )
    );

    return $response->json();
});

Route::get('/wallets/users/{id}', function ($id) {
    $wallet = new WalletConnector();
    $response = $wallet->send(
        new GetWalletByUserIdRequest(
            id: $id
        )
    );

    return $response->json();
});
