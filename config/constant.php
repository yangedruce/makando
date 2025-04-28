<?php

/*
|--------------------------------------------------------------------------
| Constant Configuration
|--------------------------------------------------------------------------
|
| Define all of the constant values that will be used across application. 
| This provides a central place for managing constant values.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    |
    | Define status for various tables in your application. 
    |
    */
    'status' => [
        /*
         | Newly created restaurant will have `Pending` as default status. When
         | restaurant is approved, it will be set to `Active`.
         */
        'restaurant' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'Pending',
            'banned' => 'Banned',
        ],
        /*
         | Newly created order will have `New` as default status. When
         | restaurant is proceeding, it will be set to `Proceeding`.
         */
        'order' => [
            'new' => 'New',
            'proceeding' => 'Proceeding',
            'pending' => 'Pending',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ],
        'menu' => [
            'available' => 'Available',
            'unavailable' => 'Unavailable',
        ],
        'payment' => [
            'pending' => 'Pending',
            'paid' => 'Paid',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions Configuration
    |--------------------------------------------------------------------------
    |
    | Define permissions for various submodules in your application. Each
    | permission allows a specific action within a given submodule. 
    |
    */

    'permission' => [
        /*
        |--------------------------------------------------------------------------
        | Dashboard Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Dashboard submodule. These  permissions 
        | allow users to dashboard data.
        |
        */

        [
            'name' => 'dashboard:read',
            'description' => 'Able to read data in dashboard submodule.',
        ],
        /*
        |--------------------------------------------------------------------------
        | Shope Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Shop submodule. These  permissions allow 
        | users to shop data.
        |
        */

        [
            'name' => 'shop:read',
            'description' => 'Able to read data in shop submodule.',
        ],



        /*
        |--------------------------------------------------------------------------
        | Order Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Order submodule. These permissions allow 
        | users to create, read, update, and delete order data.
        |
        */

        [
            'name' => 'order:create',
            'description' => 'Able to create data in Order submodule.',
        ],
        [
            'name' => 'order:read',
            'description' => 'Able to read data in Order submodule.',
        ],
        [
            'name' => 'order:update',
            'description' => 'Able to update data in Order submodule.',
        ],
        [
            'name' => 'order:delete',
            'description' => 'Able to delete data in Order submodule.',
        ],

        /*
        |--------------------------------------------------------------------------
        | Restaurant Approval Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Restaurant Approval submodule. These 
        | permissions allow users to read and update restaurant approval data.
        |
        */

        [
            'name' => 'restaurant-approval:read',
            'description' => 'Able to read data in Restaurant Approval submodule.',
        ],
        [
            'name' => 'restaurant-approval:update',
            'description' => 'Able to update data in Restaurant Approval submodule.',
        ],

        /*
        |--------------------------------------------------------------------------
        | User Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the User submodule. These permissions allow 
        | users to create, read, update, and delete user data.
        |
        */

        [
            'name' => 'user:create',
            'description' => 'Able to create data in User submodule.',
        ],
        [
            'name' => 'user:read',
            'description' => 'Able to read data in User submodule.',
        ],
        [
            'name' => 'user:update',
            'description' => 'Able to update data in User submodule.',
        ],
        [
            'name' => 'user:delete',
            'description' => 'Able to delete data in User submodule.',
        ],

        /*
        |--------------------------------------------------------------------------
        | Role Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Role submodule. These permissions allow 
        | users to create, read, update, and delete role-related data.
        |
        */

        [
            'name' => 'role:create',
            'description' => 'Able to create data in Role submodule.',
        ],
        [
            'name' => 'role:read',
            'description' => 'Able to read data in Role submodule.',
        ],
        [
            'name' => 'role:update',
            'description' => 'Able to update data in Role submodule.',
        ],
        [
            'name' => 'role:delete',
            'description' => 'Able to delete data in Role submodule.',
        ],

        /*
        |--------------------------------------------------------------------------
        | Activity Log Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Activity Log submodule. These permissions 
        | allow users to read activity-log data, which tracks actions taken within
        | the system.
        |
        */

        [
            'name' => 'activity-log:read',
            'description' => 'Able to read data in Activity Log submodule.',
        ],
    ],
];
