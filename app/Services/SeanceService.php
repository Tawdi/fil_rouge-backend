<?php

namespace App\Services;

use App\Models\Seance;

class SeanceService
{
    public function create(array $data): Seance
    {
        return Seance::create($data);
    }

    public function update(Seance $seance, array $data): Seance
    {
        $seance->update($data);
        return $seance;
    }

    public function findById(int $id): ?Seance
    {
        return Seance::with('movie','room.cinema')->findOrFail($id);
    }

    public function delete(Seance $seance): void
    {
        $seance->delete();
    }
    public function getForSeanceCinema($cinemaId, array $filters = [])
    {
        $query = Seance::with('movie', 'room')->whereHas('room', 
            function ($query) use ($cinemaId) {
            $query->where('cinema_id', $cinemaId);
            });
            
            if (!empty($filters['room_id'])) {
                $query->where('room_id', $filters['room_id']);
            }
        
            if (!empty($filters['movie_id'])) {
                $query->where('movie_id', $filters['movie_id']);
            }
        
            if (!empty($filters['start_date'])) {
                $query->whereDate('start_time', '>=', $filters['start_date']);
            }
        
            if (!empty($filters['end_date'])) {
                $query->whereDate('start_time', '<=', $filters['end_date']);
            }
        
            return $query->get();
    }

    public function getSeancesForMovie($movieId)
    {
        $seances = Seance::with(['room.cinema'])
            ->where('movie_id', $movieId)
            ->where('start_time', '>', now())
            ->get()
            ->groupBy(function ($seance) {
                return $seance->room->cinema->id;
            });
            
        return $seances->map( function ($group ,$cinemaId){
            return [
                'cinema_id' =>$cinemaId,
                'cinema_name'=> optional($group->first()->room->cinema)->name,
                'cinema_address'=> optional($group->first()->room->cinema)->address,
                'seances' => $group->map( function($seance){
                    return [ 
                        'id'=>$seance->id ,
                        'start_time'=>$seance->start_time,
                    ];
                })->values(),
            ];
        })->values() ;
    }
}
