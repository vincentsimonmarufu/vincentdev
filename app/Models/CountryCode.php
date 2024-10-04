<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    protected $table = 'countries';
    protected $fillable = ['dial_code', 'code', 'name'];

    public function airports()
    {
        return $this->hasMany(Airport::class, 'country', 'code');
    }
}
