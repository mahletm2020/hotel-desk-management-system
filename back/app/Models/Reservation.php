<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function reservationRooms()
    {
        return $this->hasMany(ReservationRoom::class);
    }
}
