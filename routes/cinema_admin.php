<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'role:cinema_admin'])->group(function(){
    Route::get('/cinema-only', function () {
        return response()->json(['message' => 'Access  cinema admin']);
    });
});