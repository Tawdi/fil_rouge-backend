<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'titre',
        'duration',
        'rating',
        'description',
        'release_date',
        'director',
        'actors',
        'poster',
        'background',
        'trailer',
        'genre_id'
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
