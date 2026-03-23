<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    protected $fillable = [
        'stay_id',
        'name',
        'amount',
        'notes',
    ];

    public function stay()
{
    return $this->belongsTo(Stay::class);
}
}
