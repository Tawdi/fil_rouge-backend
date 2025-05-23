<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::get('/google/redirect', [GoogleAuthController::class, 'redirect']);
    Route::get('/google/callback', [GoogleAuthController::class, 'callback']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
});

Route::middleware(['auth:api', 'active'])->post('/password/change', [PasswordController::class, 'update']);
