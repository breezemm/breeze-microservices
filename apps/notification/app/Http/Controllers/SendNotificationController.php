<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;
use App\Jobs\SendFirebasePushNotification;
use App\Models\User;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;


class SendNotificationController extends Controller
{

    public function __construct(public readonly Messaging $messaging)
    {
    }

    public function __invoke(NotificationSendRequest $request)
    {
        try {
            $user = $this->getUser($request->validated('user.user_id'));
            $userSetting = $user->settings;

            $pushEnabled = $userSetting['channels']['push']['enabled'];

            if (!$pushEnabled) {
                return response()->noContent(); // Indicate success without message
            }

            $message = [
                'uuid' => Str::uuid(),
                ...$request->validated(),
            ];

            SendFirebasePushNotification::dispatch($message);

            return response()->json(['message' => 'Notification sent']);
        } catch (MessagingException|FirebaseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal error'], 500);
        }
    }

    private function getUser(int $userId): User
    {
        return User::findOrFail($userId);
    }



}
