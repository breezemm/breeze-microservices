<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\QRCodeData;
use App\Models\Wallet;
use Illuminate\Http\Request;

class QRCodeValidationController extends Controller
{
    public function __invoke(QRCodeData $codeData)
    {
        $wallet = Wallet::findByQrCode($codeData->qr_code)->first();

        return response()->json($wallet);

    }
}
