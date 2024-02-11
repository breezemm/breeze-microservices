<?php

namespace App\Http\Controllers;

use App\Exceptions\NotificationAlreadyExisits;
use App\Http\Requests\CreateNotificationRequest;
use App\Models\NotificationType;
use App\Models\User;
use Kreait\Firebase\Contract\Messaging;

class CreateNotificationTypeController extends Controller
{


    public function __construct(public readonly Messaging $messaging)
    {
    }

    /**
     * @throws NotificationAlreadyExisits
     */
    public function __invoke(CreateNotificationRequest $request)
    {
        $userId = $request->validated('user_id');
        $notificationId = $request->validated('notification_id');

        $isNotificationTypeAlreadyExists = NotificationType::where('user_id', $userId)
            ->where('notification_id', $notificationId)
            ->exists();

        if ($isNotificationTypeAlreadyExists) {
            throw new NotificationAlreadyExisits("Notification type already exists");
        }

        $notificationType = NotificationType::create([
            'user_id' => $userId,
            'notification_id' => $notificationId,
            'settings' => [
                'channels' => [
                    'email' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ],
                    'sms' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ],
                    'push' => [
                        'enabled' => true,
                        'frequency' => 'instant'
                    ],
                    'web_push' => [
                        'enabled' => false,
                        'frequency' => 'instant'
                    ]
                ]
            ]
        ]);


        $user = User::where('id', $userId)->first();
        $firebaseTokens = collect($user->push_tokens)
            ->map(function ($token) {
                if ($token['type'] !== 'FCM') {
                    return false;
                }
                return $token['token'];
            })
            ->toArray();

        $this->messaging->subscribeToTopic($notificationId, $firebaseTokens);

        return response()->json($notificationType, 201);
    }


}
