<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FlightResource extends JsonResource
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
            "flight_request_id" => $this->id,
            "from" => $this->from,
            "to" => $this->to,
            "airline" => $this->airline,
            "departure_date" => $this->departure_date,
            "return_date" => $this->return_date,
            "travel_class" => $this->travel_class,
            "trip_option" => $this->trip_option,
            "message" => $this->message,
            "status" => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            //"user_id" => Auth::id(),
            "user_id" => ['id' => $udetail->id, 'name' => $udetail->name, 'surname' => $udetail->surname, 'email' => $udetail->email, 'phone' => $udetail->phone],
        ];
    }
}
