<?php

namespace App\Http\Controllers;

use App\Models\SavedPost;
use Illuminate\Http\Request;

class SavedPostController extends Controller
{

    public function __invoke(Request $request)
    {
        $savedPosts = SavedPost::where('user_id', auth()->id())
            ->with('post')
            ->groupBy('created_at')
            ->paginate();

        return response()->json([
            'data' => $savedPosts
        ]);
    }
}
