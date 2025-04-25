<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
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

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
