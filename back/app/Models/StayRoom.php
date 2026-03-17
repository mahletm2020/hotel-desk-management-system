<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StayRoom extends Model
{
    public function stay()
{
    return $this->belongsTo(Stay::class);
}

public function room()
{
    return $this->belongsTo(Room::class);
}
}
