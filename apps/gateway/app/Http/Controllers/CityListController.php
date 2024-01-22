<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityListResource;
use App\Models\CityList;
use Illuminate\Http\Request;

class CityListController extends Controller
{
    public function __invoke()
    {
        $cities = CityList::all();

        return CityListResource::make($cities);
    }
}
