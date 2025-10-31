<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\AdminMiddleware;

// PUBLIC ROUTES
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn() => auth()->user());

    // ADMIN ONLY
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::post('/register', [AuthenticationController::class, 'register']);
        Route::apiResource('products', ProductController::class)->except(['index']);
        Route::apiResource('categories', CategoryController::class)->except(['index']);
    });
});
