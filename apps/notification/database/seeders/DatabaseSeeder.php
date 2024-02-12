<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\NotificationTypeEnum;
use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        foreach (NotificationTypeEnum::cases() as $case => $value) {
            NotificationType::create([
                'notification_id' => $value,
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
                ],
            ]);
        }
    }
}
