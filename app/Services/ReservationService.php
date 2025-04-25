<?php

namespace App\Services;

use App\Models\Reservation;

class ReservationService
{
    public function create(array $data)
    {
        $user = auth('api')->user();

        return Reservation::create([
            'user_id'   => $user->id,
            'seance_id' => $data['seance_id'],
            'seats'     => $data['seats'], 
        ]);
    }

    public function getUserReservations()
    {
        return Reservation::where('user_id', auth('api')->id())
                          ->with('seance.movie', 'seance.room')->latest()->get();
    }

    public function getSeanceReservations(int $seanceId)
    {
        return Reservation::where('seance_id', $seanceId)->get();
    }
}