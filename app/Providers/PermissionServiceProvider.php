<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::if('hasPermissions', function ($permissions = null) {
            if ($permissions === null) {
                return true;
            }
            
            foreach ($permissions as $permission) {
                if (auth()->check() && auth()->user()->hasPermissions($permission)) {
                    return true;
                }
            }

            return false;
        });
    }
}
