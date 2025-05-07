<?php

use App\Http\Controllers\CinemaController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\CinemaStatsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api','active', 'role:cinema_admin'])->group(function () {
    Route::get('/cinema-only', function () {
        return response()->json(['message' => 'Access  cinema admin']);
    });

    Route::prefix('cinema-admin')->group(function(){
        
        Route::apiResource('seances', SeanceController::class)->except('index');
        Route::get('/seances',[SeanceController::class,'getSeanceByCinema']);
        
        Route::apiResource('rooms', RoomController::class);
        Route::get('/dashboard', [CinemaStatsController::class, 'index']);
        Route::post('/cinema/update',[CinemaController::class, 'updateInfo']);
        Route::post('/account/update',[CinemaController::class, 'updateAdminInfo']);
        Route::get('/info',[CinemaController::class, 'info']);

    });
});
