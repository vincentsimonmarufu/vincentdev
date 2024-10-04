<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Bookable;

class TestApiController extends Controller
{
    // list of booking
    public function bookings()
    {
        return Booking::all();
    }

    // list of bookables
    public function bookables()
    {
        return Bookable::all();
    }
}
