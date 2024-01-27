<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $followers = $user->followers;

        return UserResource::collection($user->attachFollowStatus($followers));
    }
}
