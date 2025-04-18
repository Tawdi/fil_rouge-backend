<?php

namespace App\Services;

use App\Models\Cinema;

class CinemaService
{
    public function all()
    {
        return Cinema::with('user','rooms')->paginate(10);
    }

    public function create(array $data): Cinema
    {
        return Cinema::create($data);
    }

    public function update(Cinema $cinema, array $data): Cinema
    {
        $cinema->update($data);
        return $cinema;
    }

    public function delete(Cinema $cinema): void
    {
        $cinema->delete();
    }

    public function findById(int $id): ?Cinema
    {
        return Cinema::with('user','rooms')->findOrFail($id);
    }
}
