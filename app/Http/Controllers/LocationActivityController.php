<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\PictureTrait;

use App\Models\Location;
use App\Models\Activity;

class LocationActivityController extends Controller
{
    use PictureTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($location_id)
    {
        $location = Location::with('activities')->findOrFail($location_id);
        return view('locations.activities.index', compact('location'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($location_id)
    {
        $location = Location::with('activities')->findOrFail($location_id);
        return view('locations.activities.create', compact('location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $location_id)
    {
        $request->validate([
            'name' => 'string|max:255|required',
            'description' => 'string|max:255|required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'pictures.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|required'
        ]);

        $activity = new Activity;
        $activity->name = $request->input('name');
        $activity->description = $request->input('description');
        $activity->price = $request->input('price');
        $activity->location_id = $location_id;
        $activity->save();
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Activity', $activity->id, $files);
        }

        return redirect()->route('locations.activities.index', $location_id)
            ->with('status', 'Successfully added activity');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($location_id, $id)
    {
        $location = Location::findOrFail($location_id);
        $activity = Activity::with('pictures')->findOrFail($id);
        return view('locations.activities.show', compact('location', 'activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($location_id, $id)
    {
        $location = Location::findOrFail($location_id);
        $activity = Activity::findOrFail($id);
        return view('locations.activities.edit', compact('location', 'activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $location_id, $id)
    {
        $request->validate([
            'name' => 'string|max:255|required',
            'description' => 'string|max:255|required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $activity = Activity::findOrFail($id);
        $activity->name = $request->input('name');
        $activity->description = $request->input('description');
        $activity->price = $request->input('price');
        $activity->location_id = $location_id;
        $activity->save();

        return redirect()->route('locations.activities.index', $location_id)
            ->with('status', 'Successfully updated activity');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($location_id, $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return redirect()->route('locations.activities.index', $location_id)
            ->with('status', 'Successfully deleted activity');
    }
}
