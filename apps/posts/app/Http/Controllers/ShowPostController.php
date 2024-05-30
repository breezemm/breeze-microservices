<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShowPostController extends Controller
{
    public function __invoke(Post $post)
    {
//           return new EventResource($event->load([
//            'user',
//            'phases' => function (HasMany $query) {
//                $query->with([
//                    'ticketTypes.tickets',
//                ]);
//            },
//        ]));

        return $post->with('phases.ticketTypes.tickets');

    }
}
