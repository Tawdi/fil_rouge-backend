<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileImageRequest;
use App\Services\ProfileService;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends Controller
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

    public function updateProfileImage(Request $request)
    {
        $user = JWTAuth::user();

        try {
            if (!$request->hasFile('profile_image')) {
                throw new \Exception('No image uploaded');
            }
            $image = $request->file('profile_image');
            $path = $image->store('profile_images', 'public');
            // return response()->json($path);

            $user->profile_image = $path;
            $user->save();

            return response()->json(['image' => asset('storage/' . $path)], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
