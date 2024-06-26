<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use MyanmarCyberYouths\Breeze\Breeze;

class GetAllFollowingController extends Controller
{
    public function __construct(
        public readonly Breeze $breeze,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $userId = $request->route('id');

        $followings = Follow::where('follower_id', $userId)->get();

        $followingIds = $followings->pluck('following_id')->toArray();

        $users = $this->breeze->auth()->users($followingIds)
            ->collect()
            ->keyBy('id');

        $followBackStatuses = Follow::whereIn('follower_id', $followingIds)
            ->where('following_id', $userId)
            ->pluck('follower_id')
            ->toArray();

        $followingsWithFollowingStatus = $followings->map(function ($following) use ($users, $followBackStatuses) {
            $following->setAttribute('has_followed', in_array($following->following_id, $followBackStatuses));
            $following->setAttribute('user', $users->get($following->following_id));

            return $following;
        });

        return response()->json([
            'data' => $followingsWithFollowingStatus,
        ]);
    }
}
