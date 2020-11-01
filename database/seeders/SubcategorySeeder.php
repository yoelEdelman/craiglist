<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getJson = File::get("database/data/subCategories.json");
        $decodedSubCategories = json_decode($getJson);

        foreach ($decodedSubCategories as $dataSubCategorie) {
            $subCategory = new Subcategory();
            $subCategory->name = $dataSubCategorie->name;
            $subCategory->slug = Str::slug( $dataSubCategorie->name);
            $subCategory->slug_category = Str::slug( $dataSubCategorie->slug_category);
            $subCategory->save();
        }
    }
}
