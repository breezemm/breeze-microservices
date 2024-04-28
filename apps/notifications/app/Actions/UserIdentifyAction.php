<?php

namespace App\Actions;

use App\Models\User;

class UserIdentifyAction implements Action
{
    public function handle($data): void
    {
        User::create([
            'user_id' => $data['user_id'],
            'email' => $data['email'] ?? null,
            'settings' => [
                'channels' => [
                    'email' => [
                        'enabled' => false,
                        'frequency' => 'instant',
                    ],
                    'sms' => [
                        'enabled' => false,
                        'frequency' => 'instant',
                    ],
                    'push' => [
                        'enabled' => true,
                        'frequency' => 'instant',
                    ],
                    'web_push' => [
                        'enabled' => false,
                        'frequency' => 'instant',
                    ],
                ],
            ],
        ]);
    }
}
