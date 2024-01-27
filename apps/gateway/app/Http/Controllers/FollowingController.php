<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $followings = $user->followings()
            ->with('followable')
            ->get()
            ->map(function ($following) {
                return $following->followable;
            });

        return UserResource::collection($user->attachFollowStatus($followings));
    }
}
