<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreBus;
use App\Http\Requests\UpdateBus;
use Illuminate\Http\Request;

use App\Traits\PictureTrait;
use App\Traits\CountryTrait;

use App\Models\User;
use App\Models\Bus;

class UserBusController extends Controller
{
    use PictureTrait;
    use CountryTrait;


    /**
     * Add bus route 
     * 
     */
    // public function addBusRoute(){
    //     return 'addBusRoute';
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        if (Auth::id() == $user_id || Auth::user()->role == 'admin') {
            $user = User::with('buses')->findOrFail($user_id);
            return view('users.buses.index', compact('user'));
        }
        return back()->withErrors('Insufficient permissions to access this page');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        $user = User::findOrFail($user_id);
        $countries = $this->getCountries();
        return view('users.buses.create', compact('user', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBus $request, $user_id)
    {
        $Bus = new Bus;
        $Bus->name = $request->input('name');
        $Bus->seater = $request->input('seater');
        $Bus->seater = $request->input('seater');
        $Bus->address = $request->input('address');
        $Bus->city = $request->input('city');
        $Bus->country = $request->input('country');
        $Bus->make = $request->input('make');
        $Bus->model = $request->input('model');
        $Bus->year = $request->input('year');
        $Bus->engine_size = $request->input('engine_size');
        $Bus->fuel_type = $request->input('fuel_type');
        $Bus->weight = $request->input('weight');
        $Bus->color = $request->input('color');
        $Bus->transmission = $request->input('transmission');
        $Bus->price = $request->input('price');
        $Bus->status = $request->input('status');
        $Bus->user_id = $user_id;
        $Bus->save();
        if ($files = $request->file('pictures')) {
            $this->storePicture('Bus', $Bus->id, $files);
        }

        if (Auth::id() == $user_id) {
            return redirect()->route('users.bus.index', $user_id)->with('status', 'Successfully added Bus');
        }
        return redirect()->route('buses.index')->with('status', 'Successfully added Bus');
    }
}
