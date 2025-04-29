<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CinemaStatsService;

class CinemaStatsController extends Controller
{
    protected $cinemaStatsService;
    protected $cinemaId;
    public function __construct()
    {

        $this->cinemaId = auth('api')->user()->cinema->id ?? null;
        if (!$this->cinemaId) {
            abort(400, 'No cinema associated with this admin.');
        }

        $this->cinemaStatsService = new CinemaStatsService($this->cinemaId);
    }

    public function index()
    {
        $stats = [
            'movies_count' => $this->cinemaStatsService->moviesCount(),
            'rooms_count' => $this->cinemaStatsService->roomsCount(),
            'seances_count' => $this->cinemaStatsService->seancesCount(),
            'reservations_count' => $this->cinemaStatsService->reservationsCount(),
            'recent_reservations' => $this->cinemaStatsService->recentReservations(),
            'seats_sold' => $this->cinemaStatsService->seatsSoldCount(),
        ];

        return response()->json($stats);
    }
}
