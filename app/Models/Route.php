<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    // protected $casts = [
    //     'via_cities' => 'array',
    // ];
    
    protected $fillable = ['name'];   

    // public function buslocs()
    // {
    //     return $this->belongsToMany('App\Models\Busloc');

    // }

    // public function locations()
    // {
    //     return $this->belongsToMany('App\Location')
    //         ->withPivot('order', 'minutes_from_departure')
    //         ->orderBy('location_route.order')
    //         ->withTimestamps();
    // }

    public function rides()
    {
        return $this->hasMany('App\Models\Ride');
    }

    public function getTravelDuration()
    {
        //return $this->locations->last()->minutesFromDepartureFormatted();
        return $this->buslocs->last()->minutesFromDepartureFormatted();
    }

}
