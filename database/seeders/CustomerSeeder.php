<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::where('email', 'customer1@email.com')->first();
        $user2 = User::where('email', 'customer2@email.com')->first();
        $user3 = User::where('email', 'customer3@email.com')->first();

        if ($user1 && $user2 && $user3) {
            Customer::create(
                [
                    'user_id' => $user1->id,
                    'phone_no' => '01122223333',
                    'address' => '123, Jalan Example, Kuala Lumpur',
                    'total_points' => 100,
                    'status' => 'Active',
                ]);
                
            Customer::create(
                [
                    'user_id' => $user2->id,
                    'phone_no' => '01133334444',
                    'total_points' => 200,
                    'status' => 'Active',
                ]);
                
            Customer::create([
                    'user_id' => $user3->id,
                    'total_points' => 300,
                    'status' => 'Inactive',
            ]);
        }
    }
}
