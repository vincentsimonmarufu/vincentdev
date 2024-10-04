<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateTravel extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'industry',
        'email',
        'phone',
        'address',
        'budget',
        'trips',
        'authorized_person'
    ];
}
