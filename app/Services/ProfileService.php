<?php

namespace App\Services;

use App\Http\Requests\UpdateProfileImageRequest;
use App\Models\User;
use Illuminate\Http\Request;
class ProfileService
{
    public function updateProfile(User $user, array $data): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];

        $user->save();

        return $user;
    }

    // public function updateProfileImage(User $user, UpdateProfileImageRequest $request): string
    // {
    //     if (!$request->hasFile('profile_image')) {
    //         throw new \Exception('No image uploaded');
    //     }
    
    //     $image = $request->file('profile_image');
    //     $path = $image->store('profile_images', 'public');
    
    //     $user->profile_image = $path;
    //     $user->save();
    
    //     return $path;
    // }
}
