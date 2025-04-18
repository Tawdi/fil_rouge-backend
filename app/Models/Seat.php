<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['number', 'row', 'seat_type_id', 'room_id'];

    public function seatType()
    {
        return $this->belongsTo(SeatType::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
