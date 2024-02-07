<?php

namespace App\Http\Controllers;

use App\Models\NotificationType;
use App\Http\Requests\UpdateNotificationSettingsRequest;
use App\Models\User;

class UpdateNotificationController extends Controller
{
    public function __invoke(UpdateNotificationSettingsRequest $request)
    {

        $payload = $request->validated();
        $notificationTypes = collect($request->validated('notification_types'));

        $user = User::where('user_id', $payload['user_id'])->first();

        $notificationTypes->each(function ($notificationType) use ($user) {
            $settings = $user->notificationTypes()
                ->where('notification_id', $notificationType['notification_id'])
                ->first();

            $settings->update([
                'settings' => $notificationType['settings']
            ]);
        });


        return response()->json(['message' => 'Settings updated successfully']);
    }
}
