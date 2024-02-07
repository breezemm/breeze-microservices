<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Models\NotificationType;
use App\Models\User;
use function example\int;

class CreateNotificationTypeController extends Controller
{

    public function __invoke(CreateNotificationRequest $request)
    {
        try {
            $data = $request->validated();
            $user = User::where('user_id', (integer)$data['user_id'])->first();

            $notificationType = $user
                ->notificationTypes()
                ->create([
                    ...$request->validated(),
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

            return response()->json([
                'message' => 'Notification created successfully.',
                'data' => [
                    'notification' => $notificationType
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating notification.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
