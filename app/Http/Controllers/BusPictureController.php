<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\PictureTrait;

use App\Models\Bus;
use App\Models\Picture;

class BusPictureController extends Controller
{
    use PictureTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($Bus_id)
    {
        $Bus = Bus::with('pictures')->findOrFail($Bus_id);
        return view('bus.pictures.index', compact('Bus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $Bus_id)
    {
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Bus', $Bus_id, $files);
        }

        return back()->with('status', 'Successfully added pictures');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Bus_id, $picture_id)
    {
        $Bus = Bus::with('pictures')->findOrFail($Bus_id);
        if ($Bus->pictures->count() > 1)
        {
            $picture = Picture::findOrFail($picture_id);
            if ($picture->picture_id == $Bus_id)
            {
                $this->destroyPicture($picture, 'Bus');
            }
            else
            {
                return back()->withErorrs('Picture does not belong to this Bus!');
            }
        }
        else
        {
            return back()->withErrors('Error: You need to have at least 1 picture');
        }

        return back()->with('status', 'Successfully deleted picture');
    }
}
