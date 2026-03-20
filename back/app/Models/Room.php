<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function roomType()
{
    return $this->belongsTo(RoomType::class);
}

public function stayRooms()
{
    return $this->hasMany(StayRoom::class);
}
   protected $fillable = [
    'room_number',
    'room_type_id',
    'floor',
    'status',
    'notes',
];
}
