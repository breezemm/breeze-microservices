<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class UnfollowUserController extends Controller
{
    public function __invoke(Request $request)
    {
        if ((integer)$request->route('id') === auth()->id()) {
            return response()->json([
                'message' => 'You cannot unfollow yourself.'
            ], 400);
        }

        Follow::where('follower_id', auth()->id())
            ->where('following_id', $request->route('id'))
            ->delete();

        return response()->json([
            'message' => 'User unfollowed.'
        ]);
    }
}
