<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\AdLocation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserLocation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Ad::factory(15)->create();
        //AdLocation::factory(15)->create();
        //UserLocation::factory(5)->create();
        //User::factory(5)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
