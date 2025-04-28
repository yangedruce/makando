<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = config('constant.permission');

        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Able to access all modules and submodules',
                'is_editable' => false,
                'is_deletable' => false
            ],
            [
                'name' => 'Customer',
                'description' => 'Able to access dashboard module',
                'is_editable' => false,
                'is_deletable' => false
            ],
            [
                'name' => 'Restaurant Manager',
                'description' => 'Able to manage their restaurant, menus, and orders',
                'is_editable' => false,
                'is_deletable' => false
            ],
        ];

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'email_verified_at' => '2024-05-12 16:45:04',
                'password' => Hash::make('admin123'),
                'is_force_password_change' => false,
            ],
            [
                'name' => 'Customer1',
                'email' => 'customer1@email.com',
                'email_verified_at' => '2024-05-12 16:45:04',
                'password' => Hash::make('customer123'),
                'is_force_password_change' => false,
            ],
            [
                'name' => 'Customer2',
                'email' => 'customer2@email.com',
                'email_verified_at' => '2024-05-12 16:45:04',
                'password' => Hash::make('customer123'),
                'is_force_password_change' => false,
            ],
            [
                'name' => 'Customer3',
                'email' => 'customer3@email.com',
                'email_verified_at' => '2024-05-12 16:45:04',
                'password' => Hash::make('customer123'),
                'is_force_password_change' => false,
            ],
            [
                'name' => 'Restaurant Manager 1',
                'email' => 'manager1@email.com',
                'email_verified_at' => '2024-05-12 16:45:04',
                'password' => Hash::make('manager123'),
                'is_force_password_change' => false,
            ],
            [
                'name' => 'Restaurant Manager 2',
                'email' => 'manager2@email.com',
                'email_verified_at' => '2024-05-12 16:45:04',
                'password' => Hash::make('manager123'),
                'is_force_password_change' => false,
            ],
        ];

        // Create Permission.
        foreach($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'description' => $permission['description'],
            ]);
        }

        // Create Role.
        foreach($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'description' => $role['description'],
                'is_editable' => $role['is_editable'],
                'is_deletable' => $role['is_deletable']
            ]);
        }

        // Assign permissions to roles.
        $adminRole = Role::where('name', 'admin')->first();
        $customerRole = Role::where('name', 'customer')->first();
        $managerRole = Role::where('name', 'Restaurant Manager')->first();
        
        foreach(Permission::all() as $permission) {
            if (in_array(explode(':', $permission->name)[0], ['dashboard', 'shop', 'order', 'customer', 'restaurant', 'restaurant-approval', 'category', 'menu', 'type', 'activity-log', 'user', 'role'])) {
                $adminRole->permissions()->attach($permission);
            }
        }

        foreach(Permission::all() as $permission) {
            if (in_array(explode(':', $permission->name)[0], ['dashboard', 'shop', 'order'])) {
                if(!in_array($permission->name, ['order:create', 'order:update', 'order:delete'])) {
                    $customerRole->permissions()->attach($permission);
                }
            }
        }

        foreach(Permission::all() as $permission) {
            if (in_array(explode(':', $permission->name)[0], ['dashboard', 'shop', 'order', 'customer', 'restaurant','category', 'menu', 'type'])) {
                $managerRole->permissions()->attach($permission);
            }
        }

        // Create User.
        foreach($users as $user) {
            $currentUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => $user['email_verified_at'],
                'password' => $user['password'],
                'is_force_password_change' => $user['is_force_password_change']
            ]);

            if ($currentUser->name == 'Admin') {
                $currentUser->roles()->attach($adminRole);
            }
            if ($currentUser->name == 'Customer1' || $currentUser->name == 'Customer2' || $currentUser->name == 'Customer3') {
                $currentUser->roles()->attach($customerRole);
            }
            if ($currentUser->name == 'Restaurant Manager 1' || $currentUser->name == 'Restaurant Manager 2') {
                $currentUser->roles()->attach($managerRole);
            }
        }
    }
}
