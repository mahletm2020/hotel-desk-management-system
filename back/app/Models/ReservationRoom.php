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
}
