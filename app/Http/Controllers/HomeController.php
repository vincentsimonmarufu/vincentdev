<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Bus;
use App\Models\Vehicle;
use App\Models\Shuttle;
use App\Models\Booking;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $apartments = Apartment::with('bookings')
            ->where('user_id', Auth::id())
            ->get();
       
        $vehicles = Vehicle::with('bookings')
            ->where('user_id', Auth::id())
            ->get();
            
        $buses = Bus::with('bookings')
            ->where('user_id', Auth::id())
            ->get();
            
        $shuttles = Shuttle::with('bookings')
            ->where('user_id', Auth::id())
            ->get();
        return view('home', compact('apartments', 'vehicles', 'buses', 'shuttles'));
    }
}
