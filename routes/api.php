<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;

Route::get('/test', function () {
    return response()->json(['message' => 'API route is working!']);
});

// ✅ Public routes (no auth)
Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// ✅ Protected routes
Route::middleware('auth:api')->group(function () {
    Route::post('/v1/auth/logout', [AuthController::class, 'logout']);
    Route::post('/v1/users/{user_id}', [ProfileController::class, 'update']);

    Route::get('/v1/movies', [MovieController::class, 'index']);
    Route::post('/v1/movies', [MovieController::class, 'store']);

    Route::get('/v1/user', function (Request $request) {
        return response()->json($request->user());
    });
});
