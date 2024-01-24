<?php

namespace Database\Seeders;

use App\Models\CityList;
use Illuminate\Database\Seeder;

class CityListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CityList::create(['name' => 'Yangon']);
        CityList::create(['name' => 'Mandalay']);
        CityList::create(['name' => 'Nay Pyi Taw']);
    }
}
