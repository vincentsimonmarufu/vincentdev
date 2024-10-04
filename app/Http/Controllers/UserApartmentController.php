<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\StoreApartment;

use App\Traits\PictureTrait;
use App\Traits\CountryTrait;

use App\Models\Apartment;
use App\Models\User;

class UserApartmentController extends Controller
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
            $user = User::with('apartments')->findOrFail($user_id);
            return view('users.apartments.index', compact('user'));
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
        return view('users.apartments.create', compact('user', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartment $request, $user_id)
    {
        $apartment = new Apartment;
        $apartment->name = $request->input('name');// added name 
        $apartment->address = $request->input('address');
        $apartment->city = $request->input('city');
        $apartment->country = $request->input('country');
        $apartment->guest = $request->input('guest');
        $apartment->bedroom = $request->input('bedroom');
        $apartment->bathroom = $request->input('bathroom');
        $apartment->price = $request->input('price');
        $apartment->user_id = $user_id;
        $apartment->save();
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Apartment', $apartment->id, $files);
        }

        if (Auth::id() == $user_id)
        {
            return redirect()->route('users.apartments.index', $user_id)->with('status', 'Successfully added an apartment');
        }
        else
        {
            return redirect()->route('apartments.index')->with('status', 'Successfully added an apartment');    
        }        
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
