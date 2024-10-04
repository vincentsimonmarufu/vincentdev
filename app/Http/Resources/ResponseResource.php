<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [      

            'id' => $this->id,
            'flight_request_id' => $this->flightrequest_id,
            'reply' => $this->reply,
            'image' => $this->image,
            'imageUrl' =>  !empty($this->image) ? asset('storage/public/responses/' . $this->image) : '',
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
