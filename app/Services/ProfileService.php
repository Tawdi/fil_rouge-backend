<?php

namespace App\Services;

use App\Models\User;

class ProfileService
{
    public function updateProfile(User $user, array $data): User
    {
        if (isset($data['profile_image'])) {
            $image = $data['profile_image'];
            $path = $image->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        $user->save();

        return $user;
    }
}
