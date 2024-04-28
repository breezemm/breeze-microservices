<?php

namespace App\Kafka;

use App\Actions\Action;
use App\Actions\NotificationSendAction;
use App\Actions\UserIdentifyAction;
use Illuminate\Support\Facades\Log;

class ActionMapper
{
    public function mapPatternToAction(string $pattern): ?Action
    {
        switch ($pattern) {
            case 'notifications.send':
                return new NotificationSendAction;
            case 'users.identify':
                return new UserIdentifyAction;
            default:
                Log::error('No action mapped for pattern: ' . $pattern);

                return null;
        }
    }
}
