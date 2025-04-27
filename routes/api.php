<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\FavouriteController;

// Group all API routes under the 'api/v1' prefix for version management

    // Authentication Routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    // routes/api.php
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // User Routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/user', [AuthController::class, 'getAuthenticatedUser']); // Get details of the authenticated user
        Route::get('/users/{user}', [UserController::class, 'show']); // Get details of a specific user
        Route::put('/users/{user}', [UserController::class, 'update']); // Update a specific user
    });

    // Version 1 API Routes
    Route::prefix('v1')->group(function () {
        Route::get('/cars', [CarController::class, 'index']);
        Route::post('/cars', [CarController::class, 'store'])->middleware('auth:api');
        Route::get('/cars/{car}', [CarController::class, 'show']);
    });

    // Favourite Routes
    Route::middleware('auth:api')->group(function () {
        Route::post('/cars/{car}/favourite', [FavouriteController::class, 'store']); // Add car to favourites
        Route::get('/users/{user}/favourites', [FavouriteController::class, 'index']); // Get user's favourite cars
    });

    // Search Route
    Route::get('/search', [CarController::class, 'search']); // Search for cars by make or model