<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class BusBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id', 'user_id', 'travel_date', 'ride_start_date', 'start_busloc_id', 'end_busloc_id', 'seats', 'status'
    ];

    protected $attributes = [
        'status' => BookingStatus::NEW
    ];

    protected $dates = [
        'travel_date', 'ride_start_date'
    ];

    public function ride()
    {
        return $this->belongsTo('App\Models\Ride');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function startLocation()
    {
        return $this->belongsTo('App\Models\Busloc', 'start_busloc_id');
    }

    public function endLocation()
    {
        return $this->belongsTo('App\Models\Busloc', 'end_busloc_id');
    }

    public function canBeCancelled(): bool
    {
        $rideDepartureTime = $this->ride->departure_time;
        $startLocationMinutesFromDeparture = $this->ride->route->locations
            ->find($this->startLocation->id)
            ->pivot->minutes_from_departure;
        $bookingDeparture = $this->ride_start_date
            ->setTimeFrom($rideDepartureTime)
            ->addMinutes($startLocationMinutesFromDeparture);

        return Carbon::now()->diffInHours($bookingDeparture, false) >= 2
            && ($this->status != BookingStatus::CANCELLED && $this->status != BookingStatus::REJECTED);
    }

    public function getDepartureTime()
    {
        $minutesFromDept = $this->ride->route->locations
            ->where('id', $this->startLocation->id)
            ->first()
            ->pivot->minutes_from_departure;

        return $this->ride->departure_time
            ->addMinutes($minutesFromDept)
            ->format('H:i');
    }

    public function getArrivalTime()
    {
        $minutesFromDept = $this->ride->route->locations
            ->where('id', $this->endLocation->id)
            ->first()
            ->pivot->minutes_from_departure;

        return $this->ride->departure_time
            ->addMinutes($minutesFromDept)
            ->format('H:i');
    }

    public function scopeNew(Builder $query)
    {
        return $query->where('status', BookingStatus::NEW);
    }
}
