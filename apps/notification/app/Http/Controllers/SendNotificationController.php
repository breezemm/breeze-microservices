<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;
use App\Models\User;
use NotificationChannels\Fcm\FcmMessage;

class SendNotificationController extends Controller
{

    public function __invoke(NotificationSendRequest $request)
    {
        $data = $request->validated();
        $userId = $request->validated('user.user_id');

        $user = User::where('id', $userId)->first();
        $fcmTokens = collect($user->push_tokens)->map(function ($token) {
            return [
                'token' => $token['token'],
                'platform' => $token['type'],
            ];
        })->toArray();

    }
}
