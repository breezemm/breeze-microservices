<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\NotificationType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $userPayload = [
            'user_id' => 1,
            'email' => 'spongebob@squarepants.com',
            'phone_number' => '+15005550006',
            'push_tokens' => [
                [
                    'type' => 'FCM',
                    'token' => 'samplePushToken',
                    'device' => [
                        'app_id' => 'com.example.app',
                        'ad_id' => '1234567890',
                        'device_id' => '1234567890',
                        'platform' => 'android',
                        'manufacturer' => 'Samsung',
                        'model' => 'SM-G930F'
                    ]
                ]
            ],
            'web_push_tokens' => [
                [
                    'sub' => [
                        'endpoint' => 'https://fcm.googleapis.com/fcm/send/fCs_4iba0Ao:APA91bGFdaU7I3****JMH_KeZwk1Xi',
                        'keys' => [
                            'p256dh' => 'zP2xFu3hMc2vNH5E2nuKkyjpZydvCk9llRUY2kP4****9aSlKcoadSV2UbvMRQ',
                            'auth' => 'CXEFun************tYe8g'
                        ]
                    ]
                ]
            ],
            'settings' => [
                'notifications' => [
                    'email' => [
                        'enabled' => true,
                        'frequency' => 'daily'
                    ],
                    'sms' => [
                        'enabled' => true,
                        'frequency' => 'daily'
                    ],
                    'push' => [
                        'enabled' => true,
                        'frequency' => 'daily'
                    ],
                    'web_push' => [
                        'enabled' => true,
                        'frequency' => 'daily'
                    ]
                ]
            ]
        ];
        $user = User::create($userPayload);
        $user->notificationTypes()->create([
            'notification_id' => 'user_followed',
            'settings' => [
                'email' => [
                    'enabled' => true,
                    'frequency' => 'instant'
                ],
                'sms' => [
                    'enabled' => true,
                    'frequency' => 'instant'
                ],
                'push' => [
                    'enabled' => true,
                    'frequency' => 'instant'
                ],
                'web_push' => [
                    'enabled' => true,
                    'frequency' => 'instant'
                ]
            ]
        ]);


    }
}
