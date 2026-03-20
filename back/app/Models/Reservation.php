<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function stays()
    {
        return $this->hasMany(\App\Models\Stay::class);
    }
    
    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }

   


    protected $fillable = [
    'guest_id',
    'room_id',
    'check_in_date',
    'check_out_date',
    'total_price',
    'status',
    'notes',
];


protected static function booted()
{
    static::creating(function ($reservation) {

        $conflict = Reservation::where('room_id', $reservation->room_id)
            ->where(function ($query) use ($reservation) {
                $query->whereBetween('check_in_date', [$reservation->check_in_date, $reservation->check_out_date])
                      ->orWhereBetween('check_out_date', [$reservation->check_in_date, $reservation->check_out_date])
                      ->orWhere(function ($q) use ($reservation) {
                          $q->where('check_in_date', '<=', $reservation->check_in_date)
                            ->where('check_out_date', '>=', $reservation->check_out_date);
                      });
            })
            ->exists();

        if ($conflict) {
            throw new \Exception('Room is already booked for these dates.');
        }
    });
}
}
