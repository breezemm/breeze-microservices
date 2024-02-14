<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GetAllNotificationController extends Controller
{
    public function __invoke()
    {
        $userId = auth()->id();

        $response = Http::notification()
            ->post('/notifications', [
                'user_id' => $userId,
            ]);

        return $response->json();
    }
}
