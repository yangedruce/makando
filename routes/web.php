<?php

use App\Http\Controllers\DashboardController as Dashboard;
use App\Http\Controllers\WebController as Web;
use App\Http\Controllers\Dashboard\ProfileController as Profile;
use App\Http\Controllers\Dashboard\OrderController as Order;
use App\Http\Controllers\Dashboard\ShopController as Shop;
use App\Http\Controllers\Dashboard\Managements\RestaurantController as Restaurant;
use App\Http\Controllers\Dashboard\Managements\CategoryController as Category;
use App\Http\Controllers\Dashboard\Managements\MenuController as Menu;
use App\Http\Controllers\Dashboard\Managements\TypeController as Type;
use App\Http\Controllers\Dashboard\Managements\CustomerController as Customer;
use App\Http\Controllers\Dashboard\Configurations\ActivityLogController as ActivityLog;
use App\Http\Controllers\Dashboard\Configurations\UserController as User;
use App\Http\Controllers\Dashboard\Configurations\RoleController as Role;

use Laravel\Cashier\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [Web::class, 'index'])->name('web.index');

Route::middleware(['auth', 'verified', 'password', 'validate'])->group(function () {
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        // Configurations
        Route::prefix('config')->name('config.')->group(function () {
            // User
            Route::prefix('user')->name('user.')->group(function () {
                Route::middleware('permission:user:read')->group(function () {
                    Route::get('', [User::class, 'index'])->name('index');
                    Route::get('/search', [User::class, 'search'])->name('search');
                    Route::get('/show/{id}', [User::class, 'show'])->name('show');
                });
                Route::middleware('permission:user:create')->group(function () {
                    Route::get('/create', [User::class, 'create'])->name('create');
                    Route::post('/store', [User::class, 'store'])->name('store');
                });
                Route::middleware('permission:user:update')->group(function () {
                    Route::get('/edit/{id}', [User::class, 'edit'])->name('edit');
                    Route::patch('/update/{id}', [User::class, 'update'])->name('update');
                });
                Route::middleware('permission:user:destroy')->group(function () {
                    Route::delete('/destroy/{id}', [User::class, 'destroy'])->name('destroy');
                });
            });

            // Role
            Route::prefix('role')->name('role.')->group(function () {
                Route::middleware('permission:role:read')->group(function () {
                    Route::get('', [Role::class, 'index'])->name('index');
                    Route::get('/show/{id}', [Role::class, 'show'])->name('show');
                });
                Route::middleware('permission:role:create')->group(function () {
                    Route::get('/create', [Role::class, 'create'])->name('create');
                    Route::post('/store', [Role::class, 'store'])->name('store');
                });
                Route::middleware('permission:role:update')->group(function () {
                    Route::get('/edit/{id}', [Role::class, 'edit'])->name('edit');
                    Route::patch('/update/{id}', [Role::class, 'update'])->name('update');
                });
                Route::middleware('permission:role:delete')->group(function () {
                    Route::delete('/destroy/{id}', [Role::class, 'destroy'])->name('destroy');
                });
            });

            // Activity Log
            // Route::prefix('activity-log')->name('activity-log.')->group(function () {
            //     Route::get('', [ActivityLog::class, 'index'])->name('index');
            // });
        });

        // Order
        Route::prefix('order')->name('order.')->group(function () {
            
            Route::middleware('permission:order:read')->group(function () {
                Route::get('', [Order::class, 'index'])->name('index');
                Route::get('/show/{id}', [Order::class, 'show'])->name('show');
            });
            // Route::middleware('permission:order:create')->group(function () {
            //     Route::get('/create', [Order::class, 'create'])->name('create');
            //     Route::post('/store', [Order::class, 'store'])->name('store');
            // });
            Route::middleware('permission:order:update')->group(function () {
                Route::get('/edit/{id}', [Order::class, 'edit'])->name('edit');
                Route::patch('/update/{id}', [Order::class, 'update'])->name('update');
                // Order Approval
                Route::get('/approve', [Order::class, 'getOrderApproval'])->name('orderApproval');
                Route::patch('/approve/{id}', [Order::class, 'updateOrderApproval'])->name('updateOrderApproval');
            });
            Route::middleware('permission:order:delete')->group(function () {
                Route::delete('/destroy/{id}', [Order::class, 'destroy'])->name('destroy');
            });
        });

        // Shop
        Route::prefix('shop')->name('shop.')->group(function () {
            Route::get('', [Shop::class, 'index'])->name('index');
            Route::get('/show/{id}', [Shop::class, 'show'])->name('show');
            Route::post('/cart/checkout', [Shop::class, 'checkout'])->name('checkout');
            Route::post('/cart/checkout/payment', [Shop::class, 'payment'])->name('checkout.payment');
            Route::get('/cart/checkout/success', [Shop::class, 'success'])->name('checkout.success');
            Route::get('/cart/checkout/cancel', [Shop::class, 'cancel'])->name('checkout.cancel');
        });

        // Managements
        Route::prefix('management')->name('management.')->group(function () {
            // Menu
            Route::prefix('menu')->name('menu.')->group(function () {
                Route::middleware('permission:menu:read')->group(function () {
                    Route::get('', [Menu::class, 'index'])->name('index');
                    Route::get('/show/{id}', [Menu::class, 'show'])->name('show');
                });
                Route::middleware('permission:menu:create')->group(function () {
                    Route::get('/create', [Menu::class, 'create'])->name('create');
                    Route::post('/store', [Menu::class, 'store'])->name('store');
                });
                Route::middleware('permission:menu:update')->group(function () {
                    Route::get('/edit/{id}', [Menu::class, 'edit'])->name('edit');
                    Route::patch('/update/{id}', [Menu::class, 'update'])->name('update');
                });
                Route::middleware('permission:menu:delete')->group(function () {
                    Route::delete('/destroy/{id}', [Menu::class, 'destroy'])->name('destroy');
                });
            });

            // Restaurant
            Route::prefix('restaurant')->name('restaurant.')->group(function () {
                Route::middleware('permission:restaurant:read')->group(function () {
                    Route::get('', [Restaurant::class, 'index'])->name('index');
                    Route::get('/show/{id}', [Restaurant::class, 'show'])->name('show');
                });
                Route::middleware('permission:restaurant:create')->group(function () {
                    Route::get('/create', [Restaurant::class, 'create'])->name('create');
                    Route::post('/store', [Restaurant::class, 'store'])->name('store');
                });
                Route::middleware('permission:restaurant:update')->group(function () {
                    Route::get('/edit/{id}', [Restaurant::class, 'edit'])->name('edit');
                    Route::patch('/update/{id}', [Restaurant::class, 'update'])->name('update');
                });
                Route::middleware('permission:restaurant:delete')->group(function () {
                    Route::delete('/destroy/{id}', [Restaurant::class, 'destroy'])->name('destroy');
                });
            });

            // Restaurant Approval
            Route::prefix('restaurant-approval')->name('restaurant-approval.')->group(function () {
                Route::get('', [Restaurant::class, 'getApproval'])->name('index')->middleware('permission:restaurant-approval:read');
                Route::patch('/update/{id}', [Restaurant::class, 'updateApproval'])->name('update')->middleware('permission:restaurant-approval:update');
            });

            // Category
            Route::prefix('category')->name('category.')->group(function () {
                Route::middleware('permission:category:read')->group(function () {
                    Route::get('', [Category::class, 'index'])->name('index');
                    Route::get('/show/{id}', [Category::class, 'show'])->name('show');
                });
                Route::middleware('permission:category:create')->group(function () {
                    Route::get('/create', [Category::class, 'create'])->name('create');
                    Route::post('/store', [Category::class, 'store'])->name('store');
                });
                Route::middleware('permission:category:update')->group(function () {
                    Route::get('/edit/{id}', [Category::class, 'edit'])->name('edit');
                    Route::patch('/update/{id}', [Category::class, 'update'])->name('update');
                });
                Route::middleware('permission:category:delete')->group(function () {
                    Route::delete('/destroy/{id}', [Category::class, 'destroy'])->name('destroy');
                });
            });

            // Types
            Route::prefix('type')->name('type.')->group(function () {
                Route::middleware('permission:type:read')->group(function () {
                    Route::get('', [Type::class, 'index'])->name('index');
                    Route::get('/show/{id}', [Type::class, 'show'])->name('show');
                });
                Route::middleware('permission:type:create')->group(function () {
                    Route::get('/create', [Type::class, 'create'])->name('create');
                    Route::post('/store', [Type::class, 'store'])->name('store');
                });
                Route::middleware('permission:type:update')->group(function () {
                    Route::get('/edit/{id}', [Type::class, 'edit'])->name('edit');
                    Route::patch('/update/{id}', [Type::class, 'update'])->name('update');
                });
                Route::middleware('permission:type:delete')->group(function () {
                    Route::delete('/destroy/{id}', [Type::class, 'destroy'])->name('destroy');
                });
            });

            // Customer
            Route::prefix('customer')->name('customer.')->group(function () {
                Route::middleware('permission:customer:read')->group(function () {
                    Route::get('', [Customer::class, 'index'])->name('index');
                    Route::get('/show/{id}', [Customer::class, 'show'])->name('show');
                });
                // Route::middleware('permission:customer:create')->group(function () {
                //     Route::get('/create', [Customer::class, 'create'])->name('create');
                //     Route::post('/store', [Customer::class, 'store'])->name('store');
                // });
                Route::middleware('permission:customer:update')->group(function () {
                    Route::get('/edit/{id}', [Customer::class, 'edit'])->name('edit');
                    Route::patch('/update/{id}', [Customer::class, 'update'])->name('update');
                });
                Route::middleware('permission:customer:delete')->group(function () {
                    Route::delete('/destroy/{id}', [Customer::class, 'destroy'])->name('destroy');
                });
            });
        });
    });

});

Route::middleware('auth', 'password')->group(function () {
    Route::get('/profile', [Profile::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Profile::class, 'update'])->name('profile.update');
    Route::patch('/profile/customer', [Profile::class, 'updateCustomer'])->name('profile.update.customer');
    Route::delete('/profile', [Profile::class, 'destroy'])->name('profile.destroy');
});

Route::post(
    '/stripe/webhook',
    [WebhookController::class, 'handleWebhook']
);

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
