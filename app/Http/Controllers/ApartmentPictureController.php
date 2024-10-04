<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\PictureTrait;

use App\Models\Apartment;
use App\Models\Picture;

class ApartmentPictureController extends Controller
{
    use PictureTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($apartment_id)
    {
        $apartment = Apartment::orderBy('id','Desc')->with('pictures')->findOrFail($apartment_id);
        return view('apartments.pictures.index', compact('apartment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $apartment_id)
    {
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Apartment', $apartment_id, $files);
        }

        return back()->with('status', 'Successfully added pictures');
    }

    public function destroy($apartment_id, $picture_id)
    {
        $apartment = Apartment::with('pictures')->findOrFail($apartment_id);
        if ($apartment->pictures->count() > 1)
        {
            $picture = Picture::findOrFail($picture_id);
            if ($picture->picture_id == $apartment_id)
            {
                $this->destroyPicture($picture, 'Apartment');
            }
            else
            {
                return back()->withErorrs('Picture does not belong to this apartment!');
            }
        }
        else
        {
            return back()->withErrors('Error: You need to have at least 1 picture');
        }

        return back()->with('status', 'Successfully deleted picture');
    }
}
