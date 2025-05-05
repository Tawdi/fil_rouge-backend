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
        $reservations = Reservation::where('user_id', auth('api')->id())
            ->with(['seance.movie', 'seance.room.cinema'])
            ->latest()
            ->get();
    
        return $reservations->map(function ($reservation) {
            $room = $reservation->seance->room;
            $rowNaming = $room->row_naming;

            $seats = collect($reservation->seats)->map(function ($seat) use ($rowNaming) {
                $row = $seat['row'];
                $column = $seat['col'];
    
                $rowLabel = $rowNaming === 'letters'
                    ? chr(65 + $row) 
                    : $row + 1;
                $columnLabel = $column + 1;

                return "{$rowLabel}-{$columnLabel}";
            });
    
            return [
                'id' => $reservation->id,
                'movieTitle' => $reservation->seance->movie->titre,
                'movieImage' => $reservation->seance->movie->poster ?? '/images/support.webp',
                'cinema' => $room->cinema->name ?? 'Unknown Cinema',
                'date' => \Carbon\Carbon::parse($reservation->seance->start_time)->format('F j, Y'),
                'time' => \Carbon\Carbon::parse($reservation->seance->start_time)->format('g:i A'),
                'seats' => $seats,
                'amount' => $this->calculateReservationAmount($reservation),
            ];
        });
    }
    
    private function calculateReservationAmount($reservation)
    {
        $pricing = json_decode($reservation->seance->pricing , true);
        $total = 0;
    
        foreach ($reservation->seats as $seat) {
            $type = $seat['type'];
            $total += $pricing[$type] ?? 0;
        }
    
        return round($total, 2);
    }

    public function getSeanceReservations(int $seanceId)
    {
        return Reservation::where('seance_id', $seanceId)->get();
    }

    public function findById($id)
    {

        $reservation = Reservation::with('seance.movie', 'seance.room.cinema')->findOrFail($id);
        if (auth('api')->id() !== $reservation->user_id) {
            abort(404, 'Unauthorized access to this reservation.');
        }
        $seance = $reservation->seance;
        $movie = $seance->movie;
        $room = $seance->room;
        $cinema = $room->cinema;

        return response()->json( [
            'movieTitle' => $movie->titre,
            'movieImage' => $movie->poster,
            'cinemaName' => $cinema->name,
            'cinemaAddress' => $cinema->address,
            'roomName' => $room->name,
            'rowNaming'=>$room->row_naming,
            'date' => $seance->start_time,
            'seats' => $reservation->seats,
            'pricing' => json_decode($seance->pricing)
        ]);
    }
}