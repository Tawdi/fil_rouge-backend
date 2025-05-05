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
            return count($reservation->seats);
        });
    }
    public function topMovies()
    {
        return Movie::whereHas('seances.room', function ($query) {
            $query->where('cinema_id', $this->cinemaId);
        })
        ->withCount([
            'seances' => function ($query) {
                $query->whereHas('reservations');
            }
        ])
        ->orderByDesc('seances_count')
        ->take(5)
        ->get();
    }

    public function upcomingSeances()
    {
        return Seance::with(['movie', 'room'])
        ->where('start_time', '>', now())
        ->orderBy('start_time') 
        ->take(5) 
        ->get(); 
        
    }
    public function reservationsTrend()
    {
        return Reservation::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->whereHas('seance.room', function ($query) {
            $query->where('cinema_id', $this->cinemaId);
        })
        ->groupBy('date')
        ->orderBy('date')
        ->get();
    }
    public function currentMovies()
    {
        return Movie::whereHas('seances', function ($query) {
            $query->where('start_time', '>=', now());
        })
        ->with('genre')
        ->distinct()
        ->take(6)
        ->get(['id', 'titre', 'poster', 'duration', 'genre_id']);
    }
    

}