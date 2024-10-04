<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlight extends FormRequest
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
            'flight_id' => 'required|string|max:191',
            'reference' => 'required|string|max:191',
            'queuingOfficeId' => 'required|string|max:10',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'currency' => 'required|string|max:7',
            'departure' => 'required|string|max:191',
            'arrival' => 'required|string|max:191',
            'airline' => 'required|string|max:191',
            'carrierCode' => 'required|string|max:191',
            'travel_class' => 'required|string|max:191',
            'flight_option' => 'required|string|max:191',
            'status' => 'required|string|max:191', //pending
            'user_id' => 'required|string|max:191'           
        ];
    }
}
