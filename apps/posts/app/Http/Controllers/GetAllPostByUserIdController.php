<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class GetAllPostByUserIdController extends Controller
{
    public function __invoke(Request $request)
    {

        $launchedPost = Post::where('user_id', auth()->id())->paginate();
        $launchedPost->load('media');

        return response()->json([
            'data' => $launchedPost
        ]);
    }
}
