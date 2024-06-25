<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class GetAllFollowerController extends Controller
{
    public function __invoke(Request $request)
    {
        $userId = $request->route('id');

        $followers = Follow::where('following_id', $userId)->get();

        // Collect all follower IDs
        $followerIds = $followers->pluck('follower_id')->toArray();

        // Retrieve follow-back statuses in one query
        $followBackStatuses = Follow::whereIn('following_id', $followerIds)
            ->where('follower_id', $userId)
            ->pluck('following_id')
            ->toArray();

        // TODO: fix status
        $followersWithFollowingStatus = $followers->map(function ($follower) use ($followBackStatuses) {
            return [
                ...$follower->toArray(),
                'has_followed' => in_array($follower->follower_id, $followBackStatuses),
            ];
        });

        return response()->json([
            'data' => $followersWithFollowingStatus,
        ]);
    }
}
