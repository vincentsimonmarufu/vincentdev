<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'guest' => 'required|integer|min:1',
            'bedroom' => 'required|integer|min:1',
            'bathroom' => 'required|integer|min:1',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'status' => 'required|string',

        ];
    }
}
