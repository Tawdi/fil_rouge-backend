<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)), 
                'role' => 'user',
                'profile_image' => $googleUser->getAvatar(),
            ] 
        );

        $token = JWTAuth::fromUser($user);

        $refreshToken = auth('api')
        ->setTTL(10080) // 7 days
        ->claims(['type' => 'refresh'])
        ->fromUser($user);

        return redirect()->to(env('FRONTEND_URL') . "/auth/callback?token=$token")
        ->withCookie(cookie(
            'refresh_token',
            $refreshToken,
            10080,     
            null,
            null,
            true,    
            true,          
            false,
            'None'        
        ));


        // return response()->json([
        //     'user' => $user,
        //     'token' => $token
        // ]);
    }
}
