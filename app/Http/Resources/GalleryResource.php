<?php

namespace App\Http\Resources;

use App\GalleryPicture;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Gallery;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'gallery_id' => $this->id,
            'place_name' => $this->place_name,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'created_date' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_date' => $this->updated_at->format('Y-m-d H:i:s'),
            'gallery-pictures' => GalleryPictureResource::collection(Gallery::find($this->id)->galleryPictures),
        ];
    }
}
