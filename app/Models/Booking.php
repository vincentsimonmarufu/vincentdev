<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function apartments()
    {
        return $this->morphedByMany(Apartment::class, 'bookable')
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

    public function vehicles()
    {
        return $this->morphedByMany(Vehicle::class, 'bookable')
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
    public function buses()
    {
        return $this->morphedByMany(Bus::class, 'bookable')
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

    public function shuttles()
    {
        return $this->morphedByMany(Shuttle::class, 'bookable')
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
