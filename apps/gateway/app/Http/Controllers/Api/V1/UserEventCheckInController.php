<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\QRCodeStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ScanQRCodeRequest;
use App\Models\Order;

class UserEventCheckInController extends Controller
{
    public function getTicketByQRCode(ScanQRCodeRequest $request)
    {
        $order = Order::where('qr_code', $request->qr_code)
            ->with('user.media')
            ->with('ticket.ticketType')
            ->firstOrFail();

        return response()->json([
            'order' => $order,
        ]);
    }

    public function checkInEvent(ScanQRCodeRequest $request)
    {
        $order = Order::where('qr_code', $request->qr_code)
            ->firstOrFail();

        if ($order->qr_code_status === QRCodeStatusEnum::USED) {
            return response()->json([
                'message' => 'QR Code already used.',
            ], 422);
        }

        $order->update([
            'qr_code_status' => QRCodeStatusEnum::USED,
        ]);

        return response()->json([
            'order' => $order,
        ]);
    }
}
