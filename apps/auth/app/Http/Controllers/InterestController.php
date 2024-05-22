<?php

namespace App\Http\Controllers;

use App\Http\Resources\InterestResource;
use App\Models\Interest;
use Illuminate\Support\Facades\Cache;

class InterestController extends Controller
{
    /**
     * Get all interests.
     * @return mixed
     */
    public function __invoke()
    {
        $interests = Interest::all();

        return Cache::remember('interests', 3600, function () use ($interests) {
            return InterestResource::collection($interests);
        });
    }
}
