<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); 
        $restaurant = Restaurant::first(); 

        if ($user && $restaurant) {
            $restaurant->update(['is_opened' => true]);

            Order::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'restaurant_id' => $restaurant->id,
                'status' => 'Pending',
                'type' => 'Delivery',
                'total_price' => 50.00,
                'payment_status' => 'Paid',
                'points' => 10,
            ]);

            Order::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'restaurant_id' => $restaurant->id,
                'status' => 'Completed',
                'type' => 'Pickup',
                'total_price' => 30.00,
                'payment_status' => 'Paid',
                'points' => 5,
            ]);
        } else {
            echo "Please ensure you have at least one user and one restaurant in the database.";
        }
    }
}
