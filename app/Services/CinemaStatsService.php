<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Room;
use App\Models\Seance;
use App\Models\Reservation;

class CinemaStatsService
{
    protected $cinemaId;

    public function __construct($cinemaId)
    {
        $this->cinemaId = $cinemaId;
    }

    public function moviesCount()
    {
        return Movie::whereHas('seances.room', function ($query) {
            $query->where('cinema_id', $this->cinemaId);
        })->distinct()->count();
    }

    public function roomsCount()
    {
        return Room::where('cinema_id', $this->cinemaId)->count();
    }

    public function seancesCount()
    {
        return Seance::whereHas('room', function ($query) {
            $query->where('cinema_id', $this->cinemaId);
        })->count();
    }

    public function reservationsCount()
    {
        return Reservation::whereHas('seance.room', function ($query) {
            $query->where('cinema_id', $this->cinemaId);
        })->count();
    }

    public function recentReservations()
    {
        return Reservation::whereHas('seance.room', function ($query) {
            $query->where('cinema_id', $this->cinemaId);
        })
        ->latest()
        ->take(5)
        ->get();
    }

    public function seatsSoldCount()
    {
        return Reservation::whereHas('seance.room', function ($query) {
            $query->where('cinema_id', $this->cinemaId);
        })->get()->sum(function ($reservation) {
            return count(json_decode($reservation->seats, true));
        });
    }
}
