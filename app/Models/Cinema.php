<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    protected $fillable = [
        'name',
        'address',
        'user_id',
        'image',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
