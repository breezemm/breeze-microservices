<?php

namespace App\Http\Controllers;

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
