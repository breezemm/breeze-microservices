<?php

use App\Enums\WalletType;
use App\Models\Wallet;
use Illuminate\Support\Facades\Route;

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
    $fromWallet = Wallet::where('user_id', 11)
        ->where('type', WalletType::DEBIT)
        ->first();
    $fromWallet->balance = (float)$fromWallet->balance - 100;
    $fromWallet->save();
    return  $fromWallet;
    return view('welcome');
});

Route::get('/health', function () {
    return response()->json([
        'status' => 200,
        'message' => 'Wallet service is healthy.'
    ]);
});
