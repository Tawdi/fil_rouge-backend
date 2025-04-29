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
        return Seance::with('movie','room')->findOrFail($id);
    }

    public function delete(Seance $seance): void
    {
        $seance->delete();
    }
    public function getForSeanceCinema($cinemaId)
    {
        return Seance::with('movie', 'room')->whereHas('room', 
            function ($query) use ($cinemaId) {
            $query->where('cinema_id', $cinemaId);
            })->get();
    }
}
