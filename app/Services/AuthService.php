<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        $token = JWTAuth::fromUser($user);

        return compact('user', 'token');
    }

    public function login(array $credentials): ?string
    {
        return auth('api')->attempt($credentials);
    }


     public static function changePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return true;
    }

    public function refreshToken(string $refreshToken): ?string
    {
        try {
            // Validate the refresh token
            $payload = JWTAuth::setToken($refreshToken)->getPayload();
            if ($payload['type'] !== 'refresh') {
                throw new \Exception('Invalid token type');
            }

            // Refresh the access token
            return JWTAuth::setToken($refreshToken)->refresh();
        } catch (\Exception $e) {
            throw new \Exception('Failed to refresh token');
        }
    }
}
