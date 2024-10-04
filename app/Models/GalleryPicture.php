<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryPicture extends Model
{
    protected $fillable = ['path', 'gallery_id'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
