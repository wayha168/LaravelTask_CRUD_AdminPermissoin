<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Public API
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

// Protected API
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn() => auth()->user());

    Route::middleware('admin')->group(function () {
        Route::post('/register', [AuthenticationController::class, 'register']);

        Route::apiResource('products', ProductController::class)
            ->except(['index'])
            ->names('products.api');

        Route::apiResource('categories', CategoryController::class)
            ->except(['index'])
            ->names('categories.api'); // ← NO CONFLICT
    });
});
