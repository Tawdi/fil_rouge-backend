<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); 

        if ($user->status !== 'active') {
            return response()->json(['message' => 'Forbidden - Inactive account'], 403);
        }

        return $next($request);
    }
}
