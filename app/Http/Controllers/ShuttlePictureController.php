<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\PictureTrait;

use App\Models\Shuttle;
use App\Models\Picture;

class ShuttlePictureController extends Controller
{
    use PictureTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($shuttle_id)
    {
        $shuttle = Shuttle::with('pictures')->findOrFail($shuttle_id);
        return view('shuttles.pictures.index', compact('shuttle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $shuttle_id)
    {
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Shuttle', $shuttle_id, $files);
        }

        return back()->with('status', 'Successfully added pictures');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shuttle_id, $picture_id)
    {
        $shuttle = shuttle::with('pictures')->findOrFail($shuttle_id);
        if ($shuttle->pictures->count() > 1)
        {
            $picture = Picture::findOrFail($picture_id);
            if ($picture->picture_id == $shuttle_id)
            {
                $this->destroyPicture($picture, 'shuttle');
            }
            else
            {
                return back()->withErorrs('Picture does not belong to this shuttle!');
            }
        }
        else
        {
            return back()->withErrors('Error: You need to have at least 1 picture');
        }

        return back()->with('status', 'Successfully deleted picture');
    }
}
