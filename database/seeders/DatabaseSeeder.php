<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CitiesSeeder::class,
            CategorySeeder::class,
            SubcategorySeeder::class,
            AdvertSeeder::class,
            UserSeeder::class
        ]);
    }
}
