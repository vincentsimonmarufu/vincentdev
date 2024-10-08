<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    public function flightBooking()
    {
        return $this->belongsTo(FlightBooking::class);
    }
}
