<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'id' => Str::uuid(),
                'name' => 'Asian',
                'user_id' => User::where('email', 'manager2@email.com')->first()->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Western',
                'user_id' => User::where('email', 'manager1@email.com')->first()->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Western',
                'user_id' => User::where('email', 'manager2@email.com')->first()->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Fast Food',
                'user_id' => User::where('email', 'manager1@email.com')->first()->id,
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Chinese',
                'user_id' => User::where('email', 'manager2@email.com')->first()->id,
            ],
        ]);
    }
}
