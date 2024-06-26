<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use MyanmarCyberYouths\Breeze\Breeze;

class GetAllFollowerController extends Controller
{

    public function __construct(
        public readonly Breeze $breeze,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $userId = $request->route('id');

        $followers = Follow::where('following_id', $userId)->get();
        $followerIds = $followers->pluck('follower_id')->toArray();

        $users = $this->breeze->auth()->users($followerIds)
            ->collect()
            ->keyBy('id');

        $followBackStatuses = Follow::whereIn('following_id', $followerIds)
            ->where('follower_id', $userId)
            ->pluck('following_id')
            ->toArray();

        $followersWithFollowingStatus = $followers->map(function (Follow $follower) use ($users, $followBackStatuses) {
            $follower->setAttribute('has_followed', in_array($follower->follower_id, $followBackStatuses));
            $follower->setAttribute('user', $users->get($follower->follower_id));
            return $follower;
        });


        return response()->json([
            'data' => $followersWithFollowingStatus,
        ]);
    }
}
