<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationRoom extends Model
{
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
    protected $fillable = [
        'reservation_id',
        'room_type_id',
        'quantity',
        'price',
    ];  
   public function room()
{
    return $this->belongsTo(Room::class);
}
}
