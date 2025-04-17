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
}
