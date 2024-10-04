<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class MyBookingResource extends JsonResource
{
    public function toArray($request)
    {
        $user = User::findOrFail($this->user_id);
        $types = [];

        foreach ($user->bookings as $booking) {
            if ($booking->id === $this->id) { // Check if the current booking
                if ($booking->apartments->count() > 0) {
                    $types[] = "Apartment";
                } elseif ($booking->vehicles->count() > 0) {
                    $types[] = "Vehicle";
                } else {
                    $types[] = "N/A";
                }
                
                break; // Exit the loop after finding the type for the current booking
            }
        }

        return [
            'id' => $this->id,
            'customerDetail' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email],
            'type' => implode(', ', $types), // Join types array with comma
            'date' => $this->created_at->format('Y-m-d H:i:s'),
            'checkIn' => $this->start_date,
            'checkOut' => $this->end_date,
            'reference' => $this->reference,
            'paymentStatus' => $this->status,
            'bookingId' => $this->id,
            'created_date' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_date' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
    
}
