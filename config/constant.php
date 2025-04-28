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
        | Customer Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Customer submodule. These permissions allow 
        | users to create, read, update, and delete customer data.
        |
        */

        [
            'name' => 'customer:create',
            'description' => 'Able to create data in Customer submodule.',
        ],
        [
            'name' => 'customer:read',
            'description' => 'Able to read data in Customer submodule.',
        ],
        [
            'name' => 'customer:update',
            'description' => 'Able to update data in Customer submodule.',
        ],
        [
            'name' => 'customer:delete',
            'description' => 'Able to delete data in Customer submodule.',
        ],

        /*
        |--------------------------------------------------------------------------
        | Restaurant Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Restaurant submodule. These permissions allow 
        | users to create, read, update, and delete restaurant data.
        |
        */

        [
            'name' => 'restaurant:create',
            'description' => 'Able to create data in Restaurant submodule.',
        ],
        [
            'name' => 'restaurant:read',
            'description' => 'Able to read data in Restaurant submodule.',
        ],
        [
            'name' => 'restaurant:update',
            'description' => 'Able to update data in Restaurant submodule.',
        ],
        [
            'name' => 'restaurant:delete',
            'description' => 'Able to delete data in Restaurant submodule.',
        ],

        /*
        |--------------------------------------------------------------------------
        | Restaurant Approval Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Restaurant submodule. These permissions allow 
        | users to create, read, update, and delete restaurant data.
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
        | Category Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Category submodule. These permissions allow 
        | users to create, read, update, and delete category data.
        |
        */

        [
            'name' => 'category:create',
            'description' => 'Able to create data in Category submodule.',
        ],
        [
            'name' => 'category:read',
            'description' => 'Able to read data in Category submodule.',
        ],
        [
            'name' => 'category:update',
            'description' => 'Able to update data in Category submodule.',
        ],
        [
            'name' => 'category:delete',
            'description' => 'Able to delete data in Category submodule.',
        ],
        
        /*
        |--------------------------------------------------------------------------
        | Menu Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Menu submodule. These permissions allow 
        | users to create, read, update, and delete menu data.
        |
        */

        [
            'name' => 'menu:create',
            'description' => 'Able to create data in Menu submodule.',
        ],
        [
            'name' => 'menu:read',
            'description' => 'Able to read data in Menu submodule.',
        ],
        [
            'name' => 'menu:update',
            'description' => 'Able to update data in Menu submodule.',
        ],
        [
            'name' => 'menu:delete',
            'description' => 'Able to delete data in Menu submodule.',
        ],
        
        /*
        |--------------------------------------------------------------------------
        | Type Permissions
        |--------------------------------------------------------------------------
        |
        | Permissions for managing the Type submodule. These permissions allow 
        | users to create, read, update, and delete type data.
        |
        */

        [
            'name' => 'type:create',
            'description' => 'Able to create data in Type submodule.',
        ],
        [
            'name' => 'type:read',
            'description' => 'Able to read data in Type submodule.',
        ],
        [
            'name' => 'type:update',
            'description' => 'Able to update data in Type submodule.',
        ],
        [
            'name' => 'type:delete',
            'description' => 'Able to delete data in Type submodule.',
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

        // [
        //     'name' => 'activity-log:read',
        //     'description' => 'Able to read data in Activity Log submodule.',
        // ],
    ],
];
