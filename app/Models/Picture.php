<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function picture()
    {
        return $this->morphTo();
    }
}
