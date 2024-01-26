<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class FriendSuggestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $searchTerm = trim($request->input('search', ''));

        $friends = User::where('id', '!=', auth()->id())
            ->where(function ($query) use ($request, $searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('username', 'like', "%{$searchTerm}%")
                    ->whereNotIn('id', $request->user()->followings()->pluck('id'));
            })
            ->latest('created_at')
            ->paginate(10);

        return UserResource::collection($friends);
    }
}
