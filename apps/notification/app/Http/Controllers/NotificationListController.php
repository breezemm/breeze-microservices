<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationListIndexRequest;
use App\Models\NotificationList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NotificationListController extends Controller
{
    public function index(NotificationListIndexRequest $request)
    {
        $page = $request->input('page', 1);
        return Cache::remember('notifications' . $page, 60, function () use ($request) {
            return NotificationList::where('user_id', $request->validated('user_id'))
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        });
    }
}
