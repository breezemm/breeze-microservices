<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class GetAllFollowingController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = $request->route('id');

        $followings = Follow::where('follower_id', $userId)->get();

        // Collect all following IDs
        $followingIds = $followings->pluck('following_id')->toArray();

        // Retrieve follow-back statuses in one query
        $followBackStatuses = Follow::whereIn('follower_id', $followingIds)
            ->where('following_id', $userId)
            ->pluck('follower_id')
            ->toArray();

        $followingsWithFollowingStatus = $followings->map(function ($following) use ($followBackStatuses) {
            return array_merge(
                $following->toArray(),
                ['has_followed' => in_array($following->following_id, $followBackStatuses)]
            );
        });

        return response()->json([
            'data' => $followingsWithFollowingStatus,
        ]);
    }
}
