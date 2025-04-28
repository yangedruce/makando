<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ProductTypeServiceProvider extends ServiceProvider
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
        Blade::if('isTyre', function ($productType) {
            return $productType == config('constant.product_type.tyre');
        });

        Blade::if('isRims', function ($productType) {
            return $productType == config('constant.product_type.rims');
        });
        
        Blade::if('isTyreOrTyreRims', function ($productType) {
            return in_array($productType, [config('constant.product_type.tyre'), config('constant.product_type.tyre_rims')]);
        });

        Blade::if('isRimsOrTyreRims', function ($productType) {
            return in_array($productType, [config('constant.product_type.rims'), config('constant.product_type.tyre_rims')]);
        });
    }
}
