<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreShuttle;
use App\Http\Requests\UpdateShuttle;

use App\Traits\PictureTrait;
use App\Traits\CountryTrait;

use App\Models\User;
use App\Models\Shuttle;

class UserShuttleController extends Controller
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
        if (Auth::id() == $user_id || Auth::user()->role == 'admin') {
            $user = User::with('shuttles')->findOrFail($user_id);
            return view('users.shuttles.index', compact('user'));
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
        return view('users.shuttles.create', compact('user', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShuttle $request, $user_id)
    {
        //return $request->all();
        $shuttle = new Shuttle;
        $shuttle->name = $request->input('name');
        $shuttle->seater = $request->input('seater');
        $shuttle->address = $request->input('address');
        $shuttle->city = $request->input('city');
        $shuttle->country = $request->input('country');
        $shuttle->make = $request->input('make');
        $shuttle->model = $request->input('model');
        $shuttle->year = $request->input('year');
        $shuttle->engine_size = $request->input('engine_size');
        $shuttle->fuel_type = $request->input('fuel_type');
        $shuttle->weight = $request->input('weight');
        $shuttle->color = $request->input('color');
        $shuttle->transmission = $request->input('transmission');
        $shuttle->price = $request->input('price');
        $shuttle->status = $request->input('status');
        $shuttle->user_id = $user_id;
        $shuttle->save();
        if ($files = $request->file('pictures')) {
            $this->storePicture('Shuttle', $shuttle->id, $files);
        }

        if (Auth::id() == $user_id) {
            return redirect()->route('users.shuttle.index', $user_id)->with('status', 'Successfully added shuttle');
        }
        return redirect()->route('shuttles.index')->with('status', 'Successfully added shuttle');
    }
}
