<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'seats_count',
        'cinema_id',
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
