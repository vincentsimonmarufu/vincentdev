<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassengerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'flight_booking_id' => 'required|exists:flight_bookings,id',
            'passengers.*.firstName' => 'required|string',
            'passengers.*.lastName' => 'required|string',
            'passengers.*.dob' => 'required|date',
            'passengers.*.gender' => 'required|string',
            'passengers.*.emailAddress' => 'required|email',
            'passengers.*.countryCallingCode' => 'required|string',
            'passengers.*.number' => 'required|string',
            'passengers.*.passport' => 'sometimes|file|mimes:jpeg,png,pdf|max:2048',
        ];
    }
}
