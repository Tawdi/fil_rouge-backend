<?php

namespace App\Services;

use App\Models\Seat;

class SeatService
{
    public function create(array $data): Seat
    {
        return Seat::create($data);
    }

    public function update(Seat $seat, array $data): Seat
    {
        $seat->update($data);
        return $seat;
    }

    public function delete(Seat $seat): void
    {
        $seat->delete();
    }

    public function getByRoom(int $roomId)
    {
        return Seat::where('room_id', $roomId)->with('seatType')->get();
    }
}
