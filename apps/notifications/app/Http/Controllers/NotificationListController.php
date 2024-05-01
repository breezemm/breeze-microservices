<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationListIndexRequest;
use App\Models\NotificationList;
use Illuminate\Support\Facades\Cache;

class NotificationListController extends Controller
{
    public function index(NotificationListIndexRequest $request)
    {
        $page = $request->input('page', 1);
        $userId = $request->validated('user_id');

        return Cache::remember(
            "notifications:{$userId}:page:{$page}",
            60,
            fn () => NotificationList::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        );
    }
}
