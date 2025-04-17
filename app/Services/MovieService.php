<?php

namespace App\Services;

use App\Models\Movie;

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

    public function update(Movie $movie, array $data): Movie
    {
        $movie->update($data);
        return $movie;
    }

    public function delete(Movie $movie): void
    {
        $movie->delete();
    }
}
