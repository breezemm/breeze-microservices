<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CityListResource;
use App\Models\CityList;

class CityListController extends Controller
{
    public function __invoke()
    {
        $cities = CityList::all();

        return CityListResource::make($cities);
    }
}
