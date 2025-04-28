<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CartController;

Route::middleware('auth:sanctum')->group(function () {
    // Cart
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::post('/cart/remove', [CartController::class, 'removeFromCart']);
    Route::post('/cart/clear', [CartController::class, 'clearFromCart']);
    Route::post('/cart/latest', [CartController::class, 'getLatestCart']);
});