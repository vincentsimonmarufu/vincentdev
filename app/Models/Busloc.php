<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Busloc extends Model
{
    use HasFactory;

    protected $fillable = ['buslocation'];

    public function routes()
    {
        return $this->belongsToMany(Route::class)
        ->withTimestamps();
    }

    // public function routes()
    // {
    //     return $this->belongsToMany('App\Models\Route')
    //         ->withPivot('order', 'minutes_from_departure')
    //         ->withTimestamps();
    // }

    public function minutesFromDepartureFormatted()
    {
        $minutes = $this->pivot->minutes_from_departure;

        if (floor($minutes / 60) > 0) {
            return sprintf('%dh %02dmin', floor($minutes / 60), $minutes % 60);
        }

        return sprintf('%2dmin', floor($minutes % 60));
    }

    public function getOrderInRoute(int $routeId): int
    {
        return $this->routes->find($routeId)->pivot->order;
    }

    public function getMinutesFromDepartureInRoute(int $routeId): int
    {
        return $this->routes->find($routeId)->pivot->minutes_from_departure;
    }
}
