<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Amenity;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amenities = Amenity::orderBy('id','Desc')->get();
        return view('amenities.index', compact('amenities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('amenities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required|max:255',
            'icon' => 'string|required|max:255'
        ]);
        $amenity = new Amenity;
        $amenity->name = $request->input('name');
        $amenity->icon = $request->input('icon');
        $amenity->save();

        return redirect()->route('amenities.index')->with('status', 'Successfully added amenity');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('amenities.show', compact('amenity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('amenities.edit', compact('amenity'));
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
        $request->validate([
            'name' => 'string|required|max:255',
            'icon' => 'string|required|max:255'
        ]);
        $amenity = Amenity::findOrFail($id);
        $amenity->name = $request->input('name');
        $amenity->icon = $request->input('icon');
        $amenity->save();

        return redirect()->route('amenities.index')->with('status', 'Successfully updated amenity');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();
        return redirect()->route('amenities.index')->with('status', 'Successfully deleted Amenity');
    }
}
