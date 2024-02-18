<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTokenRequest;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;

class StoreTokenController extends Controller
{
    public function __construct(private Messaging $messaging)
    {
    }

    public function __invoke(StoreTokenRequest $request)
    {

        try {
            $user = $request->user();

            $result = $this->messaging->validateRegistrationTokens($request->token);

            if (count($result['invalid']) > 0) {
                return response()->json(['message' => 'Invalid push token'], 422);
            }

            $tokens = collect($user->push_tokens);

            if ($tokens->contains('token', $request->token)) {
                return response()->json(['message' => 'Push token already exists'], 422);
            }

            $user->push_tokens = [
                ...$tokens,
                [
                    'type' => $request->type,
                    'token' => $request->token
                ]
            ];
            $user->save();

            return response()->json(['message' => 'Push token added successfully']);
        } catch (MessagingException|FirebaseException $e) {
            return response()->json(['message' => 'Invalid push token'], 422);
        }

    }
}
