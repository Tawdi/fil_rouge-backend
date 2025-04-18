<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatType extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_seat_type')->withPivot('price')->withTimestamps();
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
