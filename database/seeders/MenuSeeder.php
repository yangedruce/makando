<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Type;
use App\Models\Restaurant;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $burgerTypeId = Type::where('name', 'Burgers')->first()?->id;
        $pizzaTypeId = Type::where('name', 'Pizzas')->first()?->id;
        $drinksTypeId = Type::where('name', 'Drinks')->first()?->id;
        $appetizersTypeId = Type::where('name', 'Appetizers')->first()?->id;

        $burgerRestaurant = Restaurant::where('name', 'Burger Kingdom')->first();
        $pizzaRestaurant = Restaurant::where('name', 'Pizza Empire')->first();

        if (!$burgerRestaurant || !$pizzaRestaurant || !$burgerTypeId || !$pizzaTypeId || !$drinksTypeId || !$appetizersTypeId) {
            $this->command->error('Required data is missing (restaurant or category)');
            return;
        }

        $burgerRestaurant->update(['is_opened' => true]);
        $pizzaRestaurant->update(['is_opened' => true]);

        $menus = [
            [
                'id' => Str::uuid(),
                'restaurant_id' => $burgerRestaurant->id,
                'type_id' => $burgerTypeId,
                'name' => 'Classic Cheeseburger',
                'description' => 'Grilled beef patty with cheese, lettuce, tomato, and sauce.',
                'price' => 12.90,
                'is_available' => true,
            ],
            [
                'id' => Str::uuid(),
                'restaurant_id' => $burgerRestaurant->id,
                'type_id' => $burgerTypeId,
                'name' => 'Double Patty Burger',
                'description' => 'Two juicy beef patties with melted cheddar.',
                'price' => 18.50,
                'is_available' => true,
            ],
            [
                'id' => Str::uuid(),
                'restaurant_id' => $pizzaRestaurant->id,
                'type_id' => $pizzaTypeId,
                'name' => 'Pepperoni Pizza',
                'description' => 'Classic pepperoni with mozzarella and tomato sauce.',
                'price' => 22.00,
                'is_available' => true,
            ],
            [
                'id' => Str::uuid(),
                'restaurant_id' => $pizzaRestaurant->id,
                'type_id' => $pizzaTypeId,
                'name' => 'Margherita Pizza',
                'description' => 'Fresh tomato, basil, and mozzarella.',
                'price' => 20.00,
                'is_available' => true,
            ],
            [
                'id' => Str::uuid(),
                'restaurant_id' => $burgerRestaurant->id,
                'type_id' => $drinksTypeId,
                'name' => 'Coca Cola',
                'description' => 'Refreshing soda drink.',
                'price' => 3.00,
                'is_available' => true,
            ],
            [
                'id' => Str::uuid(),
                'restaurant_id' => $burgerRestaurant->id,
                'type_id' => $drinksTypeId,
                'name' => 'Orange Juice',
                'description' => 'Freshly squeezed orange juice.',
                'price' => 4.50,
                'is_available' => true,
            ],
            [
                'id' => Str::uuid(),
                'restaurant_id' => $pizzaRestaurant->id,
                'type_id' => $appetizersTypeId,
                'name' => 'Garlic Bread',
                'description' => 'Toasted bread with garlic and butter.',
                'price' => 6.00,
                'is_available' => true,
            ],
            [
                'id' => Str::uuid(),
                'restaurant_id' => $pizzaRestaurant->id,
                'type_id' => $appetizersTypeId,
                'name' => 'Mozzarella Sticks',
                'description' => 'Crispy fried mozzarella cheese sticks.',
                'price' => 8.00,
                'is_available' => true,
            ]
        ];

        Menu::insert($menus);

        $menuImages = [
            'Classic Cheeseburger' => [
                'path' => 'storage/images/classic_cheeseburger.jpg',
                'name' => 'Classic Cheeseburger Image',
            ],
            'Double Patty Burger' => [
                'path' => 'storage/images/double_patty_burger.jpg',
                'name' => 'Double Patty Burger Image',
            ],
            'Pepperoni Pizza' => [
                'path' => 'storage/images/pepperoni_pizza.jpg',
                'name' => 'Pepperoni Pizza Image',
            ],
            'Margherita Pizza' => [
                'path' => 'storage/images/margherita_pizza.jpg',
                'name' => 'Margherita Pizza Image',
            ],
            'Coca Cola' => [
                'path' => null,
                'name' => 'Coca Cola Image',
            ],
            'Orange Juice' => [
                'path' => null,
                'name' => 'Orange Juice Image',
            ],
            'Garlic Bread' => [
                'path' => null,
                'name' => 'Garlic Bread Image',
            ],
            'Mozzarella Sticks' => [
                'path' => null,
                'name' => 'Mozzarella Sticks Image',
            ],
        ];

        foreach ($menuImages as $menuName => $imageData) {
            $menu = Menu::where('name', $menuName)->first();
            if ($menu) {
                $menu->image()->create($imageData);
            }
        }
    }
}
