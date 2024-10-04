<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryPicture;
use App\Models\Gallery;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::with('galleryPictures')->get();
        return view('galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'place_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pictures.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|required',
        ]);

        $galleryData = ['place_name' => $validatedData['place_name'], 'description' => $validatedData['description']];
        $gallery = auth()->user::galleries()->create($galleryData);
        $picture_type = 'gallery' . '/';
        //dd($request->file('pictures'));
        if ($files = $request->file('pictures')) {
            foreach ($files as $file) {
                $full_file_name = $file->getClientOriginalName();
                $name = pathinfo($full_file_name, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $image_name_to_store = $name . '_' . time() . '.' . $extension;
                $file->storeAs('public/' . $picture_type, $image_name_to_store);
                $pictureModel = new GalleryPicture();
                $pictureModel->path = $image_name_to_store;
                $pictureModel->gallery_id = $gallery->id;
                $galleryPictureRes = $pictureModel->save();
                if (!$galleryPictureRes) {
                    return $this->sendError('Error to save gallery pictures');
                }
            }
        }
        return back()->with('status', 'Gallery created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        $galleryPictures = $gallery->galleryPictures;
        return view('galleries.show', compact('gallery', 'galleryPictures'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('galleries.edit', compact('gallery'));
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
        $gallery = Gallery::findOrFail($id);
        $gallery->place_name = $request->place_name;
        $gallery->description = $request->description;
        $gallery->save();
        if (!empty($gallery)) {
            return redirect()->route('mygallery.index')->with('status', 'Successfully updated');
        } else {
            return redirect()->route('mygallery.index')->with('status', 'Error in update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        return back()->with('status', 'Gallery deleted');
    }
}
