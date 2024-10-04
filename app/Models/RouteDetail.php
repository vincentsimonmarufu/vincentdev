<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteDetail extends Model
{
    use HasFactory;

    // 'routeids' => 'array',
    protected $casts = [        
        'locids' => 'array',
        'minutes' => 'array',
        'prices' => 'array'       
    ];

    protected $attributes = [
        'order' => 1,
    ];


    public function buslocs()
    {
        return $this->belongsToMany('App\Models\Busloc');
                               
    }

}
