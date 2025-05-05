<?php

namespace App\Services;

use App\Models\Movie;
use Carbon\Carbon;

class MovieService
{
    public function all()
    {
        return Movie::with('genre')->get();
    }

    public function create(array $data): Movie
    {
        return Movie::create($data);
    }

    public static function findById($id)
    {
        return Movie::find($id);
    }

    public function update(Movie $movie, array $data): Movie
    {
        $movie->update($data);
        return $movie;
    }

    public function delete(Movie $movie): void
    {
        $movie->delete();
    }

    public function getMoviesInCinema()
    {
        $today = Carbon::now();
         return Movie::with('genre')->whereHas('seances', function ($query) use ($today) {
            $query->where('start_time', '>', $today);
        })->get();
    }
    
}
