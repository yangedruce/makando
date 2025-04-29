<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ConfigurationSeeder::class,
            CustomerSeeder::class,
            RestaurantSeeder::class,
            TypeSeeder::class,
            CategorySeeder::class,
            CategoryRestaurantSeeder::class,
            MenuSeeder::class,
            // OrderSeeder::class,
        ]);
    }
}
