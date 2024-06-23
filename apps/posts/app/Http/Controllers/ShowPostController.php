<?php

namespace App\Http\Controllers;

use App\Models\Post;


class ShowPostController extends Controller
{
    public function __invoke(Post $post)
    {

        $post->load('media');
        $post->load('ticketTypes.phases');
        $post->load('ticketTypes.tickets');

        return response()->json(['data' => $post]);
    }
}
