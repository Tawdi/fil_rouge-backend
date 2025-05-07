<?php

namespace App\Services;

use App\Models\User;
use App\Models\Cinema;
use App\Models\Reservation;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class AdminStatsService
{
    public function getStats()
    {
        return [
            'total_users' => User::count(),
            'total_cinemas' => Cinema::count(),
            'total_reservations' => Reservation::count(),
            'total_revenue' => $this->calculateTotalRevenue(),
            'weekly_revenue'=> $this->reservationsTrend()
        ];
    }

    public function getTopMovies($limit = 5)
    {
        return Movie::select('movies.id','movies.poster', 'movies.titre', DB::raw('COUNT(reservations.id) as reservations_count'))
            ->join('seances', 'movies.id', '=', 'seances.movie_id')
            ->join('reservations', 'seances.id', '=', 'reservations.seance_id')
            ->groupBy('movies.id', 'movies.titre','movies.poster')
            ->orderByDesc('reservations_count')
            ->limit($limit)
            ->get();
    }

    public function getTopCinemas($limit = 5)
    {
        return Cinema::select('cinemas.id', 'cinemas.name', DB::raw('COUNT(reservations.id) as reservations_count'))
            ->join('rooms', 'cinemas.id', '=', 'rooms.cinema_id')
            ->join('seances', 'rooms.id', '=', 'seances.room_id')
            ->join('reservations', 'seances.id', '=', 'reservations.seance_id')
            ->groupBy('cinemas.id', 'cinemas.name')
            ->orderByDesc('reservations_count')
            ->limit($limit)
            ->get();
    }

    private function calculateTotalRevenue()
    {
        return Reservation::join('seances', 'reservations.seance_id', '=', 'seances.id')
        ->select(DB::raw('SUM(jsonb_array_length(reservations.seats) * (seances.pricing->>\'Standard\')::numeric) as total'))
        ->value('total') ?? 0;
    }

    public function reservationsTrend()
    {
        return Reservation::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get();
    }
}
