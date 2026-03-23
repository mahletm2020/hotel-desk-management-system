<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'stay_id',
        'amount',
        'method',
        'paid_at',
        'notes',
    ];

    public function stay()
{
    return $this->belongsTo(Stay::class);
}
}
