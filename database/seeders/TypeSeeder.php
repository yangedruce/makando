<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Type;
use App\Models\Restaurant;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $burgerRestaurant = Restaurant::where('name', 'Burger Kingdom')->first();
        $pizzaRestaurant = Restaurant::where('name', 'Pizza Empire')->first();

        Type::insert([
            [
                'id' => Str::uuid(),
                'name' => 'Burgers',
                'restaurant_id' => $burgerRestaurant->id, 
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pizzas',
                'restaurant_id' => $pizzaRestaurant->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Drinks',
                'restaurant_id' => $burgerRestaurant->id, 
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Desserts',
                'restaurant_id' => $pizzaRestaurant->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Salads',
                'restaurant_id' => $burgerRestaurant->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pastas',
                'restaurant_id' => $pizzaRestaurant->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sides',
                'restaurant_id' => $burgerRestaurant->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Appetizers',
                'restaurant_id' => $pizzaRestaurant->id,
            ],
        ]);
    }
}
