<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreVehicle;
use App\Http\Requests\UpdateVehicle;
use Illuminate\Http\Request;

use App\Traits\PictureTrait;
use App\Traits\CountryTrait;

use App\Models\User;
use App\Models\Vehicle;

class UserVehicleController extends Controller
{
    use PictureTrait;
    use CountryTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        if (Auth::id() == $user_id || Auth::user()->role == 'admin')
        {
            $user = User::with('vehicles')->findOrFail($user_id);
            return view('users.vehicles.index', compact('user'));
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
        return view('users.vehicles.create', compact('user', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicle $request, $user_id)
    {
        $vehicle = new Vehicle;
        $vehicle->name = $request->input('name');
        $vehicle->address = $request->input('address');
        $vehicle->city = $request->input('city');
        $vehicle->country = $request->input('country');
        $vehicle->make = $request->input('make');
        $vehicle->model = $request->input('model');
        $vehicle->year = $request->input('year');
        $vehicle->engine_size = $request->input('engine_size');
        $vehicle->fuel_type = $request->input('fuel_type');
        $vehicle->weight = $request->input('weight');
        $vehicle->color = $request->input('color');
        $vehicle->transmission = $request->input('transmission');
        $vehicle->price = $request->input('price');
        $vehicle->status = $request->input('status');
        $vehicle->user_id = $user_id;
        $vehicle->save();
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Vehicle', $vehicle->id, $files);
        }

        if (Auth::id() == $user_id)
        {
            return redirect()->route('users.vehicles.index', $user_id)->with('status', 'Successfully added vehicle');
        }
        return redirect()->route('vehicles.index')->with('status', 'Successfully added vehicle');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
