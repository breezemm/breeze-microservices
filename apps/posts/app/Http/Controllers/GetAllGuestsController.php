<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Purchase;
use Illuminate\Http\Request;
use MyanmarCyberYouths\Breeze\Breeze;

class GetAllGuestsController extends Controller
{
    public function __construct(
        public readonly Breeze $breeze,
    )
    {
    }

    public function __invoke(Request $request, Post $post)
    {
        $guests = $post->purchases()
            ->with('ticket')
            ->paginate();

        $userIds = $guests->pluck('user_id')->toArray();
        $users = $this->breeze->auth()->users($userIds)->collect()->keyBy('id');

        $guests->collect()->map(fn(Purchase $purchase) => $purchase->setAttribute('user', $users->get($purchase->user_id)));

        return response()->json($guests);
    }
}
