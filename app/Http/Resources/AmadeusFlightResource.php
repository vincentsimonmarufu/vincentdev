<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AmadeusFlightResource extends JsonResource
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
        $udetail = User::findOrFail(Auth::id());       
        return [           
            "flight_request_id"=>  $this->id,
            "flightId"=> $this->flight_id,
            "reference" => $this->reference,
            "queuingOfficeId"=> "JNBZA2195",
            "Price"=> $this->price,
            "currency"=> $this->currency,
            "departure"=> $this->departure,
            "arrival"=> $this->arrival,
            "airline" => $this->airline,
            "carrierCode"=> $this->carrierCode,
            "travel_class"=> $this->travel_class,
            "flight_option"=> $this->flight_option,
            "status"=> $this->status,                        
            "userDetail" => ['id' => $udetail->id, 'name' => $udetail->name, 'surname' => $udetail->surname, 'email' => $udetail->email, 'phone' => $udetail->phone],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
