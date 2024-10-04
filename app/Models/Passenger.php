<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    protected $table = 'passengers';
    protected $fillable = [
        'flight_booking_id', 'name', 'surname', 'dob',
     'phone', 'code', 'file_path', 'email', 'gender'
    ];

    public function flight_booking()
    {
        return $this->belongsTo(FlightBooking::class,'flight_booking_id');
    }
    
}
