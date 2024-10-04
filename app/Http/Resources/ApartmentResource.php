<?php

namespace App\Http\Resources;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
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
            'guest' => $this->guest,
            'bedroom' => $this->bedroom,
            'bathroom' => $this->bathroom,
            'price' => $this->price,
            'property_type_id' => $this->property_type_id,
            'status' => $this->status,
            //'user_id' => $this->user_id,            
            'user_detail' => ['user_id' => $this->user_id, 'name' => User::find($this->user_id)->name, 'surname' => User::find($this->user_id)->surname, 'email' => User::find($this->user_id)->email, 'phone' => User::find($this->user_id)->phone],
            'created_date' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_date' => $this->updated_at->format('Y-m-d H:i:s'),
            'pictures' => PictureResource::collection(Apartment::find($this->id)->pictures),

        ];
    }
}
