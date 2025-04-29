<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\CinemaStatsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'role:cinema_admin'])->group(function () {
    Route::get('/cinema-only', function () {
        return response()->json(['message' => 'Access  cinema admin']);
    });

    Route::prefix('cinema-admin')->group(function(){
        
        Route::apiResource('seances', SeanceController::class);
        Route::apiResource('rooms', RoomController::class);
        Route::get('/dashboard', [CinemaStatsController::class, 'index']);
    });
});
