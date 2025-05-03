<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileImageRequest;
use App\Services\ProfileService;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048', 
        ]);

        $user = auth('api')->user();
        if ($request->hasFile('image')) {
            if ($user->profile_image && Storage::exists($user->profile_image)) {
                Storage::delete($user->profile_image);
            }

            $imagePath = $request->file('image')->store('profile_images', 'public');

            $user->profile_image = $imagePath;
            $user->save();

            return response()->json([
                'message' => 'Profile image uploaded successfully.',
                'imageUrl' => $imagePath,
            ]);
        }
        return response()->json(['message' => 'No image provided.'], 400);
    }
}
