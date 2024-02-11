<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;
use App\Models\User;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;


class SendNotificationController extends Controller
{

    public function __construct(public readonly Messaging $messaging)
    {
    }

    public function __invoke(NotificationSendRequest $request)
    {
        try {
            $userId = $request->validated('user.user_id');

            $user = User::where('id', $userId)->first();

            $userSetting = $user->settings;
            $isPushNotificationEnabled = $userSetting['channels']['push']['enabled'];

            if (!$isPushNotificationEnabled) {
                return false;
            }

            $firebaseTokens = collect($user->push_tokens)
                ->map(function ($token) {
                    if ($token['type'] !== 'FCM') {
                        return false;
                    }
                    return $token['token'];
                })
                ->toArray();

            $this->messaging->subscribeToTopic('all', $firebaseTokens);

            $topicMessage = CloudMessage::fromArray([
                'topic' => 'all',
                'notification' => [
                    'title' => $request->validated('channels.push.title'),
                    'body' => $request->validated('channels.push.body'),
                ],
            ]);

            $this->messaging->send($topicMessage);

            return response()->json(['message' => 'Notification sent'], 200);


        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (MessagingException|FirebaseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
