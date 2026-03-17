<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    public function stays()
    {
        return $this->hasMany(Stay::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
