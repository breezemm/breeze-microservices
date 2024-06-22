<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShowPostController extends Controller
{
    public function __invoke(Post $post)
    {

        $post->load('ticketTypes.phases');
        $post->load('ticketTypes.tickets');
        $post->load('media');

        return response()->json([
            'data' => $post,
        ]);

    }
}
