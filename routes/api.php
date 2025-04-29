<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TypeController;

Route::middleware('auth:sanctum')->group(function () {
    // Cart
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/remove', [CartController::class, 'removeFromCart']);
    Route::post('/cart/clear', [CartController::class, 'clearFromCart']);
    Route::post('/cart/latest', [CartController::class, 'getLatestCart']);

    Route::post('/category/get', [CategoryController::class, 'getCategories']);
    Route::post('/type/get', [TypeController::class, 'getTypes']);
});