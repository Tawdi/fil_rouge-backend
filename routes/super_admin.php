<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'role:super_admin'])->group(function(){
    Route::get('/admin-only', function () {
        return response()->json(['message' => 'Access  super admin']);
    });
});