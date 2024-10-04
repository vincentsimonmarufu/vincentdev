<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBookingResponse extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
