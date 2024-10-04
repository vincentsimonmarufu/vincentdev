<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pictures()
    {
        return $this->morphMany(Picture::class, 'picture');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rating');
    }

    public function bookings()
    {
        return $this->morphToMany(Booking::class, 'bookable')
            ->withPivot([
                'id',
                'start_date',
                'end_date',
                'price',
                'status',
                'booking_id'
            ])
            ->withTimestamps();
    }
}
