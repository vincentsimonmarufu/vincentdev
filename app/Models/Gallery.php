<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['place_name', 'description'];

    public function galleryPictures()
    {
        return $this->hasMany(GalleryPicture::class);
    }
}
