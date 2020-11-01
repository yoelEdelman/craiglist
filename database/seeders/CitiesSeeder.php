<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\City;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $getJson = File::get("database/data/cities.json");
        $decodedCities = json_decode($getJson);

        foreach ($decodedCities as $dataCities){
            $city = new City();
            $city->name = $dataCities->name;
            $city->zipcode = $dataCities->code;
            $city->picture = $dataCities->picture;
            $city->slug = Str::slug($dataCities->name);
            $city->save();
        }
    }
}
