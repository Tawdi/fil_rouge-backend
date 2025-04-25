<?php

use App\Http\Controllers\CinemaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeanceController;
use Illuminate\Support\Facades\Route;


Route::get('movies',[ MovieController::class,'index']);

Route::get('cinemas', [CinemaController::class,'index']);

Route::get('rooms', [RoomController::class ,'index']);
Route::get('seances', [SeanceController::class ,'index']);
Route::get('seances/{id}', [SeanceController::class ,'show']);

// Route::middleware('auth:api')->group(function () {
// });