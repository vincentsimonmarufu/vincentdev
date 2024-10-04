<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\PictureTrait;

use App\Models\Vehicle;
use App\Models\Picture;

class VehiclePictureController extends Controller
{
    use PictureTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($vehicle_id)
    {
        $vehicle = Vehicle::with('pictures')->findOrFail($vehicle_id);
        return view('vehicles.pictures.index', compact('vehicle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vehicle_id)
    {
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Vehicle', $vehicle_id, $files);
        }

        return back()->with('status', 'Successfully added pictures');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vehicle_id, $picture_id)
    {
        $vehicle = Vehicle::with('pictures')->findOrFail($vehicle_id);
        if ($vehicle->pictures->count() > 1)
        {
            $picture = Picture::findOrFail($picture_id);
            if ($picture->picture_id == $vehicle_id)
            {
                $this->destroyPicture($picture, 'Vehicle');
            }
            else
            {
                return back()->withErorrs('Picture does not belong to this vehicle!');
            }
        }
        else
        {
            return back()->withErrors('Error: You need to have at least 1 picture');
        }

        return back()->with('status', 'Successfully deleted picture');
    }
}
