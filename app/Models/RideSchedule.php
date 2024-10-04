<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = [
        'start_date', 'end_date'
    ];

    public function ride()
    {
        return $this->belongsTo('App\Models\Ride');
    }
}
