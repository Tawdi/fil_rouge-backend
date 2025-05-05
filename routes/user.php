<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api', 'role:user'])->group(function(){
    Route::get('/user-only', function () {
        return response()->json(['message' => 'Access  user ']);
    });
});

Route::post('/upload-profile', [ProfileController::class, 'upload']);

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/imgs', [GenreController::class, 'withPosters']);
Route::middleware('auth:api')->group(function(){

    Route::put('/user/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/user/profile-image', [ProfileController::class, 'updateProfileImage']);

    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::post('/create-payment-intent', [\App\Http\Controllers\StripeController::class, 'createIntent']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::post('/reservations/seance/{id}', [ReservationController::class, 'reservedSeats']);
    

    // Route::post('/payment', [PaymentController::class, 'process']);

});
