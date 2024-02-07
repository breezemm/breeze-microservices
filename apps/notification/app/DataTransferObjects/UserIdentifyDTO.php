<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UserIdentifyDTO extends Data
{

    public function __construct(
        public string $id,
        #[Unique('users', 'user_id')]
        public int    $userId,
        #[Unique('users', 'email')]
        #[Nullable]
        public string $email,
        #[Unique('users', 'phone_number')]
        #[Nullable]
        public string $phoneNumber,
        #[Nullable]
        public array  $pushTokens,
        #[Nullable]
        public array  $webPushTokens
    )
    {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'id' => 'required|string',
            'email' => 'required|email',
            'phoneNumber' => 'required|regex:/^\+[1-9]\d{1,14}$/',
            'pushTokens' => 'nullable|array',
            'pushTokens.*.type' => 'required|in:FCM,APN',
            'pushTokens.*.token' => 'required|string',
            'pushTokens.*.device' => 'required|array',
            'pushTokens.*.device.app_id' => 'required|string',
            'pushTokens.*.device.ad_id' => 'required|string',
            'pushTokens.*.device.device_id' => 'required|string',
            'pushTokens.*.device.platform' => 'required|in:android,ios',
            'webPushTokens' => 'nullable|array',

        ];
    }

}
