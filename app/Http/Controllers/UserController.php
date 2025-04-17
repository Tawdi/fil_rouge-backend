<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Http\Requests\UpdateProfileRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = JWTAuth::user();  

        $updatedUser = $this->profileService->updateProfile($user, $request->all());

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $updatedUser,
        ]);
    }
}
