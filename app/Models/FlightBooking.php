<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightBooking extends Model
{
    protected $table = 'flight_bookings';
    
    protected $fillable = [
        'flight_id', 'reference', 'queuingOfficeId', 'price',
     'currency', 'departure', 'arrival', 'airline','carrierCode', 'user_id', 'flight_option' , 'travel_class'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A flight booking has many passengers
    public function passengers()
    {
        return $this->hasMany(Passenger::class, 'flight_booking_id');
    }

    public function segments()
    {
        return $this->hasMany(Segment::class);
    }

}
