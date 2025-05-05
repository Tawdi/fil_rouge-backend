<?php

use App\Http\Controllers\CinemaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;


Route::get('movies',[ MovieController::class,'index']);
Route::get('/movies-has-seances', [MovieController::class ,'moviesInCinema']);

Route::get('cinemas', [CinemaController::class,'index']);
Route::get('cinemas/{id}', [CinemaController::class,'cinemaData']);

Route::get('rooms', [RoomController::class ,'index']);
Route::get('seances', [SeanceController::class ,'index']);
Route::get('seances/{id}', [SeanceController::class ,'show']);
Route::get('seances/movie/{id}', [SeanceController::class ,'seancesForMovie']);

Route::post('/support', [SupportController::class, 'send']);

// Route::middleware('auth:api')->group(function () {
// });