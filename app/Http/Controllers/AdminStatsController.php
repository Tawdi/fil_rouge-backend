<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AdminStatsService;

class AdminStatsController extends Controller
{
    protected $adminStatsService;

    public function __construct(AdminStatsService $adminStatsService)
    {
        $this->adminStatsService = $adminStatsService;
    }

    public function index(){
        $stats = [
            'stats'=> $this->adminStatsService->getStats(),
            'top_movies'=> $this->adminStatsService->getTopMovies(),
            'top_cinemas'=> $this->adminStatsService->getTopCinemas(),
        ];

        return response()->json($stats);
    }
}
