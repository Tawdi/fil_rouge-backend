<?php

namespace App\Services;

use App\Models\Genre;

class GenreService
{
    public function all()
    {
        return Genre::all();
    }

    public function create(array $data): Genre
    {
        return Genre::create($data);
    }

    public function update(Genre $genre, array $data): Genre
    {
        $genre->update($data);
        return $genre;
    }

    public function delete(Genre $genre): void
    {
        $genre->delete();
    }

    public function genreWithPosters()
    {
        $genres = Genre::with(['movies' => function ($query) {
            $query->select('id', 'genre_id', 'poster')
                ->whereNotNull('poster')
                ->take(4);
        }])->get();

        $result = $genres->map(function ($genre) {
            return [
                'id' => $genre->id,
                'name' => $genre->name,
                'posters' => $genre->movies->pluck('poster')->take(4)->values(),
            ];
        });

        return $result;
    }
}
