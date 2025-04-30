<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'row_naming',
        'rows',
        'seats_per_row',
        'layout',
        'cinema_id',
    ];

    protected $casts = [
        'seats' => 'array',
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
