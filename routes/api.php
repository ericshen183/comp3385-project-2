<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    // Authentication routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Cars routes
    Route::get('/cars', [CarController::class, 'index']);
    Route::post('/cars', [CarController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/cars/{car_id}', [CarController::class, 'show']);
    Route::post('/cars/{car_id}/favourite', [CarController::class, 'favourite'])->middleware('auth:sanctum');

    // Search route
    Route::get('/search', [SearchController::class, 'search']);

    // Users routes
    Route::post('/users/{user_id}', [UserController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/users/{user_id}/favourites', [UserController::class, 'addFavourite'])->middleware('auth:sanctum');
});
