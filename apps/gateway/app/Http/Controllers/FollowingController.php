<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class FollowingController extends Controller
{
    public function __invoke(Request $request, string $username)
    {
        try {

            $user = User::whereUsername($username)->firstOrFail();
            $followings = $user->followings()
                ->with('followable')
                ->get()
                ->map(function ($following) {
                    return $following->followable;
                });

            return response()->json([
                'data' => [
                    'total_followings' => $user->followings()->count(),
                    'followings' => UserResource::collection($user->attachFollowStatus($followings)),
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }
}
