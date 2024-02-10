<?php

namespace App\Http\Controllers;

use App\Models\NotificationType;
use App\Http\Requests\UpdateNotificationSettingsRequest;
use App\Models\User;

class UpdateNotificationController extends Controller
{
    public function __invoke(UpdateNotificationSettingsRequest $request)
    {
        $data = $request->validated();

        $user = User::where('user_id', $data['user_id'])->first();
        $notificationTypes = collect($data['notification_types']);

        $notificationTypes->each(function ($notificationType) use ($user) {
            $user->notificationTypes()->update([
                'settings' => $notificationType['settings']
            ]);
        });

    }
}
