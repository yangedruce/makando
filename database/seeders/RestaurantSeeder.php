<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager1 = User::where('name', 'Restaurant Manager 1')->first();
        $manager2 = User::where('name', 'Restaurant Manager 2')->first();
        Restaurant::insert([
            [
                'id' => Str::uuid(),
                'name' => 'Burger Kingdom',
                'description' => 'Famous for grilled burgers.',
                'address' => '123 Burger Street, KL',
                'status' => 'Active',
                'is_opened' => 1,
                'inactive_at' => null,
                'user_id' => $manager1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Pizza Empire',
                'description' => 'Authentic Italian pizzas.',
                'address' => '456 Pizza Avenue, KL',
                'status' => 'Active',
                'is_opened' => 1,
                'inactive_at' => null,
                'user_id' => $manager2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sushi World',
                'description' => 'Fresh sushi and sashimi.',
                'address' => '789 Sushi Lane, KL',
                'status' => 'Inactive', 
                'is_opened' => 0,
                'inactive_at' => Carbon::now()->subDays(10), 
                'user_id' => $manager1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Curry Palace',
                'description' => 'Delicious spicy curries.',
                'address' => '321 Curry Road, KL',
                'status' => 'Pending', 
                'is_opened' => 0,
                'inactive_at' => null,
                'user_id' => $manager2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
