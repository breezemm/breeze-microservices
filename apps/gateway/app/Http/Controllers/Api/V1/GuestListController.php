<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\BuyerTypeEnum;
use App\Enums\QRCodeStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;

class GuestListController extends Controller
{
    public function __invoke(Request $request, Event $event)
    {
        $filter = $request->get('filter', 'all');

        $guests = Order::where('event_id', $event->id)
            ->with('user.media')
            ->get();
        $guestCount = $guests->count();

        if ($filter === 'checked_in') {
            $guests = $guests->filter(function ($order) {
                return $order->qr_code_status === QRCodeStatusEnum::USED;
            });
        } elseif ($filter === 'left') {
            $guests = $guests->filter(function ($order) {
                return $order->qr_code_status === QRCodeStatusEnum::PENDING;
            });
        } elseif ($filter === 'buyers') {
            $guests = $guests->filter(function ($order) {
                return $order->buyer_type === BuyerTypeEnum::USER;
            });
        } elseif ($filter === 'invitees') {
            $guests = $guests->filter(function ($order) {
                return $order->buyer_type === BuyerTypeEnum::GUEST;
            });
        }

        return response()->json([
            'data' => [
                'guests_count' => $guestCount,
                'guests' => $guests,
            ],
        ]);
    }
}
