<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth:api', 'role:super_admin'])->group(function(){
    Route::get('/admin-only', function () {
        return response()->json(['message' => 'Access  super admin']);
    });
});

Route::middleware(['auth:api', 'role:cinema_admin'])->group(function(){
    Route::get('/cinema-only', function () {
        return response()->json(['message' => 'Access  cinema admin']);
    });
});

Route::middleware(['auth:api', 'role:user'])->group(function(){
    Route::get('/user-only', function () {
        return response()->json(['message' => 'Access  user ']);
    });
});

