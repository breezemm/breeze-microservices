<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowUserController extends Controller
{
    public function __invoke(Request $request)
    {
        if ((integer)$request->route('id') === auth()->id()) {
            return response()->json([
                'message' => 'You cannot follow yourself',
            ], 400);
        }

        $isFollowing = Follow::where('follower_id', auth()->id())
            ->where('following_id', $request->route('id'))
            ->exists();

        if ($isFollowing) {
            return response()->json([
                'message' => 'Already followed',
            ], 400);
        }

        Follow::create([
            'follower_id' => auth()->id(),
            'following_id' => $request->route('id'),
        ]);

        return response()->json([
            'message' => 'Followed successfully',
        ]);
    }
}
