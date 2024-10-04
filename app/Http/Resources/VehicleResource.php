<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Picture;
use App\Models\Vehicle;

class VehicleResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->year,
            'engine_size' => $this->engine_size,
            'fuel_type' => $this->fuel_type,
            'weight' => $this->weight,
            'color' => $this->color,
            'transmission' => $this->transmission,
            'price' => $this->price,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'pictures' => PictureResource::collection(Vehicle::find($this->id)->pictures),
        ];
    }
}
