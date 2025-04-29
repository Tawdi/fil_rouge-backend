<?php

use App\Http\Controllers\CinemaController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdminStatsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'role:super_admin'])->group(function(){
    Route::get('/admin-only', function () {
        return response()->json(['message' => 'Access  super admin']);
    });

    Route::prefix('admin')->group(function(){
        Route::apiResource('genres', GenreController::class);
        Route::apiResource('cinemas', CinemaController::class);
        Route::apiResource('movies', MovieController::class);
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::patch('/{id}/status', [UserController::class, 'changeStatus']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });

        Route::get('/dashboard', [AdminStatsController::class, 'index']);
    });
});
