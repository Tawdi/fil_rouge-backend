<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api', 'role:user'])->group(function(){
    Route::get('/user-only', function () {
        return response()->json(['message' => 'Access  user ']);
    });
});

