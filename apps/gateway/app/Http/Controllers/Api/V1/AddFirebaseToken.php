<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFirebaseTokenRequest;
use Illuminate\Support\Facades\Http;

class AddFirebaseToken extends Controller
{
    public function __invoke(StoreFirebaseTokenRequest $request)
    {
        $response = Http::notification()
            ->put('/notifications/tokens', [
                'user_id' => auth()->id(),
                'token' => $request->token,
                'type' => 'FCM',
            ]);

        return $response->json();
    }
}
