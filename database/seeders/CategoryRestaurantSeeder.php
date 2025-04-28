<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Restaurant;
use App\Models\Category;

class CategoryRestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $burgerRestaurant = Restaurant::where('name', 'Burger Kingdom')->first();
        $pizzaRestaurant = Restaurant::where('name', 'Pizza Empire')->first();

        $asianCategory = Category::where('name', 'Asian')->first();
        $westernCategory = Category::where('name', 'Western')->first();
        $fastFoodCategory = Category::where('name', 'Fast Food')->first();
        $chineseCategory = Category::where('name', 'Chinese')->first();

        if (!$burgerRestaurant || !$pizzaRestaurant || !$asianCategory || !$westernCategory || !$fastFoodCategory || !$chineseCategory) {
            $this->command->error('Required restaurants or categories are missing.');
            return;
        }

        DB::table('category_restaurant')->insert([
            [
                'restaurant_id' => $burgerRestaurant->id,
                'category_id' => $fastFoodCategory->id,
            ],
            [
                'restaurant_id' => $burgerRestaurant->id,
                'category_id' => $westernCategory->id,
            ],
            [
                'restaurant_id' => $pizzaRestaurant->id,
                'category_id' => $westernCategory->id,
            ],
            [
                'restaurant_id' => $pizzaRestaurant->id,
                'category_id' => $asianCategory->id,
            ],
            [
                'restaurant_id' => $pizzaRestaurant->id,
                'category_id' => $chineseCategory->id,
            ],
        ]);
    }
}
