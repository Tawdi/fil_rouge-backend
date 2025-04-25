<?php

namespace App\Services;

use App\Models\Cinema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CinemaService
{
    public function all()
    {
        return Cinema::with('user','rooms')->paginate(10);
    }

    public function create(array $data): Cinema
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('movieseat000'),
            'role' => 'cinema_admin',
        ]);
        return Cinema::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'user_id' => $user->id,
        ]);
    }

    public function update(Cinema $cinema, array $data): Cinema
    {
        $cinema->update($data);
        return $cinema;
    }

    public function delete(Cinema $cinema): void
    {
        $cinema->user->delete();
        // $cinema->delete();
    }

    public function findById(int $id): ?Cinema
    {
        return Cinema::with('user','rooms')->findOrFail($id);
    }
}
