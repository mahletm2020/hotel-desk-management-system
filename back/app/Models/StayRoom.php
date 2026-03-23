<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StayRoom extends Model
{
    protected $fillable = [
        'stay_id',
        'room_id',
        'price_per_night',
        'check_in',
        'check_out',
    ];

    public function stay()
{
    return $this->belongsTo(Stay::class);
}

public function room()
{
    return $this->belongsTo(Room::class);
}
  
public function reservation()
{
    return $this->belongsTo(\App\Models\Reservation::class);
}

}
