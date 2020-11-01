<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Julien',
            'email' => 'julien@test.com',
            'password' => Hash::make('azertyui'),
            'location_city' => "Paris",
            'current_team_id' => 1
        ]);

        User::create([
            'name' => 'Adrien',
            'email' => 'adrien@test.com',
            'password' => Hash::make('azertyui'),
            'location_city' => "Marseille",
            'current_team_id' => 1
        ]);
    }
}
