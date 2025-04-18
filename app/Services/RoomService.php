<?php

namespace App\Services;

use App\Models\Room;

class RoomService
{
    public function all()
    {
        return Room::with('cinema')->paginate(10);
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update($data);
        return $room;
    }

    public function delete(Room $room): void
    {
        $room->delete();
    }

    public function findById(int $id): ?Room
    {
        return Room::with('cinema')->findOrFail($id);
    }
}
