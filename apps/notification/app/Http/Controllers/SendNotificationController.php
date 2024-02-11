<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;
use App\Jobs\SendFirebasePushNotification;
use App\Models\NotificationList;
use App\Models\NotificationType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;

class SendNotificationController extends Controller
{

    public function __invoke(NotificationSendRequest $request)
    {
        try {
            DB::beginTransaction();
            $userId = $request->validated('user.user_id');

            $message = [
                'uuid' => Str::uuid(),
                ...$request->validated(),
            ];

            NotificationList::create([
                'user_id' => $userId,
                'message' => $request->validated('channels'),
            ]);

            DB::commit();
            SendFirebasePushNotification::dispatch($message);

            return response()->json(['message' => 'Notification sent']);
        } catch (MessagingException|FirebaseException $e) {

            DB::rollBack();
            return response()->json([
                'message' => 'Error sending notification',
            ], 400); // 400 for client-side errors
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Internal error'], 500);
        }
    }

}
