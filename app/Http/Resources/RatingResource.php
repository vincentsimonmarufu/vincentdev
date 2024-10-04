<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class RatingResource extends JsonResource
{    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $isApartment = $this->rating_type == 'App\\Models\\Apartment';
        $isVehicle = $this->rating_type == 'App\\Models\\Vehicle';
        $isBus = $this->rating_type == 'App\\Models\\Bus';
        $isShuttle = $this->rating_type == 'App\\Models\\Shuttle';

        $ratingType = $isApartment ? 'App\\Models\\Apartment' : ($isVehicle ? 'App\\Models\\Vehicle' : ($isBus ? 'App\\Models\\Bus' : ($isShuttle ? 'App\\Models\\Shuttle' : '')));
        //$pictureType = $isApartment ? 'App\\Models\\Apartment' : ($isVehicle ? 'App\\Models\\Vehicle' : ($isBus ? 'App\\Models\\Bus' : ($isShuttle ? 'App\\Models\\Shuttle' : '')));

        $dynamicKey = $isApartment ? 'apartmentId' : ($isVehicle ? 'vehicleId' : ($isBus ? 'busId':($isShuttle ? 'shuttleId' : '')));
        //$dynamicKey = $isApartment ? 'apartmentId' : ($isVehicle ? 'vehicleId' : ($isBus ? 'busId' : ($isShuttle ? 'shuttleId' : '')));
     

        //return parent::toArray($request);
        // return [
        //     'ratingId' => $this->id,
        //     'ratingType' => $this->rating_type == "App\\Apartment" ? "App\\Apartment" : "App\\Vehicle",
        //     'apartmentOrVehicleId' => $this->rating_id,
        //     'rating_score' => $this->score,
        //     'rating_comment' => $this->comment,
        //     'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        //     'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        // ];
        return [
            'ratingId' => $this->id,
            'ratingType' => $ratingType,
            $dynamicKey => (int)$this->rating_id, // Dynamic key based on the picture type           
            'rating_score' => $this->score,
            'rating_comment' => $this->comment,
            //'userId' => $this->user_id,
            'user_detail' => ['user_id' => $this->user_id, 'full_name' => User::find($this->user_id)->name." ".User::find($this->user_id)->surname],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];

    }
}
