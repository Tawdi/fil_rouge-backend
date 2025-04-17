<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\AuthService;

class PasswordController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function update(ChangePasswordRequest $request)
    {
        $user = auth('api')->user();

        $success = $this->authService->changePassword($user, $request->current_password, $request->new_password);

        if (!$success) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        return response()->json(['message' => 'Password updated successfully'],200);
    }
}
