<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $getJson = File::get("database/data/categories.json");
        $decodedCategories = json_decode($getJson);

        foreach ($decodedCategories as $dataCategories)
        {
            $category = new Category();
            $category->name = $dataCategories->name;
            $category->slug = Str::slug($dataCategories->name);
            $category->save();
        }
    }
}
