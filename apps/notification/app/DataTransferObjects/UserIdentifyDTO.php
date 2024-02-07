<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UserIdentifyDTO extends Data
{


    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => 'required|unique:users,user_id', // The ID of the user in your system. Required.
            'email' => 'nullable|email',
            'phone_number' => 'nullable|regex:/^\+[1-9]\d{1,14}$/',
            'push_tokens' => 'nullable|array',
            'push_tokens.*.type' => 'required|in:FCM,APN',
            'push_tokens.*.token' => 'required|string',
            'push_tokens.*.device' => 'required|array',
            'push_tokens.*.device.app_id' => 'nullable|string',
            'push_tokens.*.device.ad_id' => 'nullable|string',
            'push_tokens.*.device.device_id' => 'required|string',
            'push_tokens.*.device.platform' => 'nullable|in:android,ios',
            'push_tokens.*.device.manufacturer' => 'nullable|string',
            'push_tokens.*.device.model' => 'nullable|string',
            'web_push_tokens' => 'nullable|array',
            'web_push_tokens.*.sub' => 'required|array',
            'web_push_tokens.*.sub.endpoint' => 'required|string',
            'web_push_tokens.*.sub.keys' => 'required|array',
            'web_push_tokens.*.sub.keys.p256dh' => 'required|string',
            'web_push_tokens.*.sub.keys.auth' => 'required|string',
        ];
    }

}
