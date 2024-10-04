<?php

namespace App\Http\Controllers\Api;

use App\Models\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GalleryResource;
use App\Models\GalleryPicture;
use App\Http\Resources\GalleryPictureResource;

class GalleryApiController extends ResponseController
{
    /**
     * list of gallery
     */
    public function index()
    {
        try {
            //$galleries = Gallery::with('galleryPictures')->orderBy('created_at', 'DESC')->get();
            $galleries = Gallery::orderBy('created_at', 'DESC')->get();
            $galleryResources = GalleryResource::collection($galleries);
            //return new GalleryResource(Gallery::orderby('created_at', 'DESC')->get());
            return $this->sendResponse($galleryResources, 'Galleries');
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * create gallery
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'place_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pictures.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|required',
        ]);

        try {
            $galleryData = ['place_name' => $validatedData['place_name'], 'description' => $validatedData['description']];
            $gallery = auth()->user()->galleries()->create($galleryData);
            $picture_type = 'Gallery' . '/';
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
                        return $this->sendError('Error in gallery pictures');
                    }
                }
            }
            return $this->sendResponse('', 'Gallery created');
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }
}
