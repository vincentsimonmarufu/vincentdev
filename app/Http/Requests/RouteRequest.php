<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueRoutes;

class RouteRequest extends FormRequest
{
    
    public function rules()
    {
        return [        
            'name' => "required|unique:routes,name"
        ];
    }
   

}
