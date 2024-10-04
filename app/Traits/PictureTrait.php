<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Picture;
use Intervention\Image\ImageManagerStatic as Image;


trait PictureTrait
{
    protected function storePicture($picture_type, $picture_id, $files)
    {
        foreach ($files as $file) {
            $relPath = $picture_type;
            $full_file_name = $file->getClientOriginalName();
            $name = pathinfo($full_file_name, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $image_name_to_store = 'img_' . $name . '_' . time() . '.' . $extension;
            $file->storeAs($relPath, $image_name_to_store);
            //Log::info('Request data:', ['picture_type' => $picture_type, 'file' => $full_file_name, 'picture_id' => $picture_id]);
            $imageModel = new Picture();
            $imageModel->path = $image_name_to_store;
            $imageModel->picture_type = "App\\Models\\" . $relPath;
            $imageModel->picture_id = $picture_id;
            $imageModel->save();           
        }        
    }


    protected function destroyPictures($pictures, $type)
    {
        foreach ($pictures as $picture) {
            $this->destroyPicture($picture, $type);
        }
    }

    protected function destroyPicture($picture, $type)
    {
        Storage::delete('public/' . $type . '/' . $picture->path);
        $picture->delete();
    }
}
