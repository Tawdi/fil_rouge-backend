<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());
        return response()->json($result);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth('api')->user();
        $refreshToken = auth('api')
        ->setTTL(10080) // 7 days in minutes
        ->claims(['type' => 'refresh'])
        ->fromUser($user);
        
        return response()
        ->json([
            'token' => $token,
            'user' => $user
        ])
        ->cookie('refresh_token', $refreshToken, 10080, null, null, true, true, false, 'None');
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refreshToken(Request $request)
    {
        try {
            $refreshToken = $request->cookie('refresh_token');
            if (!$refreshToken) {
                return response()->json(['message' => 'No refresh token'], 401);
            }

            $newAccessToken = $this->authService->refreshToken($refreshToken);

            $user = auth('api')->user();

            return response()->json([
                'token' => $newAccessToken,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}

