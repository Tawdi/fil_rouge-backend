<?php

namespace App\Services;

use App\Models\SeatType;

class SeatTypeService
{
    public function all()
    {
        return SeatType::all();
    }

    public function create(array $data): SeatType
    {
        return SeatType::create($data);
    }

    public function update(SeatType $seatType, array $data): SeatType
    {
        $seatType->update($data);
        return $seatType;
    }

    public function delete(SeatType $seatType): void
    {
        $seatType->delete();
    }
}
