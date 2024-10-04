<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassengerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'flight_booking_id' => $this->flight_booking_id,
            'name' => $this->name,
            'surname' => $this->surname,
            'dob' => $this->dob,
            'phone' => $this->phone,
            'code' => $this->code,
            'file_path' => $this->file_path,
            'imageUrl' =>  !empty($this->file_path) ? asset('storage/public/passports/' . $this->file_path) : '',
            'email' => $this->email,
            'gender' => $this->gender
        ];

    }
}
