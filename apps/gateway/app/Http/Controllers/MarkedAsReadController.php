<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MarkedAsReadController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = auth()->id();

        $response = Http::notification()
            ->post("/notifications/{$request->notificationId}/read", [
                'user_id' => (int)auth()->id(),
            ]);


        return $response->json();
    }
}
