<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    protected $fillable = [
        'guest_id',
        'reservation_id',
        'check_in_date',
        'check_out_date',
        'status',
        'total_price',
    ];

    public function guest()
{
    return $this->belongsTo(Guest::class);
}

public function reservation()
{
    return $this->belongsTo(Reservation::class);
}

public function stayRooms()
{
    return $this->hasMany(StayRoom::class);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}

public function serviceCharges()
{
    return $this->hasMany(ServiceCharge::class);
}

public function rooms()
{
    return $this->hasManyThrough(
        Room::class,
        StayRoom::class,
        'stay_id', // Foreign key on stay_rooms
        'id',      // Foreign key on rooms
        'id',      // Local key on stays
        'room_id'  // Local key on stay_rooms
    );
}
}
