<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            LocationSeeder::class,
            TagSeeder::class,
            UserSeeder::class,
            AgeSeeder::class,
            OptionValueSeeder::class,
            CategorySeeder::class,
        ]);
        \App\Models\User::factory()->count(100)->create();
        \App\Models\Seller::factory()->count(70)->create();
        \App\Models\Outfit::factory()->count(150)->create();
        \App\Models\Comment::factory()->count(50)->create();
        // \App\Models\Order::factory()->count(20)->create();

        // \App\Models\UserAgent::factory()->count(10)->create();
        // \App\Models\Visitor::factory()->count(100)->create();
    }
}
