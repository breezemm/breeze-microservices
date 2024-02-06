<?php

namespace App\Enums;

enum NotificationChannel: string
{
    case Email = 'email';
    case SMS = 'sms';
    case Push = 'push';
    case WebPush = 'webPush';
    case InApp = 'inApp';

    public static function toArray(): array
    {
        return [
            self::Email,
            self::SMS,
            self::Push,
            self::WebPush,
            self::InApp,
        ];
    }
}
