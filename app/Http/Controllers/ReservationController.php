<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationStoreRequest;
use App\Services\ReservationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function store(ReservationStoreRequest $request) : JsonResponse
    {
        $reservation = $this->reservationService->create($request->validated());

        return response()->json([
            'message' => 'Reservation created successfully',
            'data' => $reservation
        ], 201);
    }

    public function index(): JsonResponse
    {
        $reservations = $this->reservationService->getUserReservations();

        return response()->json($reservations);
    }

    public function show($id): JsonResponse
    {
        return  $this->reservationService->findById($id);
    }

    public function reservedSeats($seanceId): JsonResponse
    {
        $reservations = $this->reservationService->getSeanceReservations($seanceId);
        $seats = $reservations->pluck('seats')->flatten(1); 

        return response()->json($seats);
    }
}
