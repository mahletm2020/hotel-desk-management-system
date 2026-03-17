<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function stay()
{
    return $this->belongsTo(Stay::class);
}
}
