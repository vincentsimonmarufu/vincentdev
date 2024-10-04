<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
   // use HasFactory;
    protected $table = 'airportsjson';
    protected $fillable = ['iata', 'lon', 'iso', 'status', 'name', 'continent', 'type', 'lat', 'size'];

    public function country()
    {
        return $this->belongsTo(CountryCode::class, 'country', 'code');
    }
}
