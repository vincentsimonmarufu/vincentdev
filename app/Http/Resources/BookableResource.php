<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\Vehicle;
use App\Models\User;

class BookableResource extends JsonResource
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
            'bookableId' => $this->id,
            'customerDetail' => ['name' => User::find(Booking::find($this->booking_id)->user_id)->name, 'surname' => User::find(Booking::find($this->booking_id)->user_id)->surname, 'email' => User::find(Booking::find($this->booking_id)->user_id)->email, 'phone' => User::find(Booking::find($this->booking_id)->user_id)->phone, 'Payment Status' => Booking::find($this->booking_id)->status],
            'ownerDetail' => $this->bookable_type == "App\\Models\\Apartment" ? $this->otherDetail(Apartment::find($this->bookable_id)) : Vehicle::find($this->bookable_id),
            'checkIn' => $this->start_date,
            'checkOut' => $this->end_date,
            'price' => $this->price,
            'status' => $this->status,
            'created_date' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_date' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }

    public function otherDetail($xyz)
    {
        return ['name' => User::find($xyz->user_id)->name, 'email' => User::find($xyz->user_id)->email, 'phone' => User::find($xyz->user_id)->phone, 'address' => $xyz->address, 'city' => $xyz->city, 'country' => $xyz->country];
    }
}
