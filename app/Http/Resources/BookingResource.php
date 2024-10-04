<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class BookingResource extends JsonResource
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
            'bookingId' => $this->id,
            'date' => $this->created_at->format('Y-m-d H:i:s'),
            'checkIn' => $this->start_date,
            'checkOut' => $this->end_date,
            'reference' => $this->reference,
            'status' => $this->status,
            'clientId' => $this->user_id,
            'created_date' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_date' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
