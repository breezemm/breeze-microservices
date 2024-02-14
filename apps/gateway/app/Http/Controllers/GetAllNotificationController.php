<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetAllNotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = auth()->id();
        $page = $request->input('page', 1);

        $response = Http::notification()
            ->post('/notifications?page=' . $page, [
                'user_id' => $userId,
            ]);

        return $response->json();
    }
}
