<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;
use App\Models\User;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;


class SendNotificationController extends Controller
{

    public function __construct(public readonly Messaging $messaging)
    {
    }

    public function __invoke(NotificationSendRequest $request)
    {
        $data = $request->validated();
        $userId = $request->validated('user.user_id');

        $user = User::where('id', $userId)->first();
        $firebaseTokens = collect($user->push_tokens)
            ->map(function ($token) {
                if ($token['type'] === 'FCM') {
                    return $token['token'];
                }
                return false;
            })
            ->toArray();

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => $request->validated('channels.push.title'),
                'body' => $request->validated('channels.push.body'),
            ],
            'data' => $request->validated('channels.push.data'),
        ]);
        $this->messaging->sendMulticast($message, $firebaseTokens);

        return $firebaseTokens;
    }
}
