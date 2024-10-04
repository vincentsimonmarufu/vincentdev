<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AmadeusResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $udetail = User::findOrFail(Auth::id());   
        return [
            'id' => $this->id,
            'flight_booking_id' => $this->flight_booking_id,
            'reply' => $this->reply,
            'image' => $this->image,
            'imageUrl' =>  !empty($this->image) ? asset('storage/public/responses/' . $this->image) : '',
            'user_id' => $this->user_id,
            "userDetail" => ['id' => $udetail->id, 'name' => $udetail->name, 'surname' => $udetail->surname, 'email' => $udetail->email, 'phone' => $udetail->phone],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
