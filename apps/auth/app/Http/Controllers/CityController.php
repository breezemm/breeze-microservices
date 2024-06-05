<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Models\City;


class CityController extends Controller
{

    /**
     * @unauthenticated
     *
     * Get all cities
     */
    public function __invoke()
    {
        return response()->json([
            'data' => [
                'cities' => CityResource::collection(City::all()),
            ],
        ]);
    }
}
