<?php

namespace App\Actions;

use App\Enums\TokenType;
use App\Jobs\SendFirebasePushNotification;
use App\Models\NotificationList;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NotificationSendAction implements Action
{
    public function handle(array $data): void
    {
        try {
            DB::beginTransaction();
            $userId = $data['user']['user_id'];

            NotificationList::create([
                'user_id' => $userId,
                'message' => $data['channels'],
            ]);
            DB::commit();


            $tokens = collect(User::where('user_id', $userId)
                ->select('push_tokens')
                ->get()
                ->pluck('push_tokens')
                ->toArray())
                ->flatten(1)
                ->map(function ($token) {
                    if ($token['type'] === TokenType::FIREBASE->value) {
                        return $token['token'];
                    }
                    return false;
                })
                ->toArray();


            foreach ($tokens as $token) {
                $message = [
                    'uuid' => Str::uuid(),
                    ...$data,
                    'token' => $token,
                ];
                SendFirebasePushNotification::dispatch($message);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error sending notification: ' . $e->getMessage());
        }
    }
}
