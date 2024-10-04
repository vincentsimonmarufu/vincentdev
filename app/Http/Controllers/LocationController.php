<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\PictureTrait;

use App\Models\Location;

class LocationController extends Controller
{
    use PictureTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::orderBy('id','Desc')->get();
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locations.create');
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
            'description' => 'string|required|max:255',
            'pictures.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|required'
        ]);

        $location = new Location;
        $location->name = $request->input('name');
        $location->description = $request->input('description');
        $location->save();
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Location', $location->id, $files);
        }

        return redirect()->route('locations.index')->with('status', 'Successfully added location');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::with('pictures')->findOrFail($id);
        return view('locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('locations.edit', compact('location'));
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
            'description' => 'string|required|max:255'
        ]);

        $location = Location::findOrFail($id);
        $location->name = $request->input('name');
        $location->description = $request->input('description');
        $location->save();

        return redirect()->route('locations.index')->with('status', 'Successfully updated location');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::with(['pictures', 'activities'])->findOrFail($id);
        if ($location->activities->count() > 0)
        {
            return back()->withErrors(['Cannot delete location with activities', 'First delete activities']);
        }
        if ($apartment->pictures->count() > 0)
        {
            $this->destroyPictures($location->pictures, 'Location');
        }
        $location->delete();
        return redirect()->route('locations.index')->with('status', 'Successfully deleted location');
    }
}