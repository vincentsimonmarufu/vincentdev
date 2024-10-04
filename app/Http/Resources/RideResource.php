<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Route;
use App\Models\Bus;
use App\Models\Ride;

class RideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ride_id' => $this->id,
            'routeName' => Route::findOrFail($this->route_id)->name,    
            'busName' => Bus::findOrFail($this->bus_id)->name,
            'departureTime' => Ride::findOrFail($this->id)->departure_time,
            'departureDate' =>  Ride::findOrFail($this->id)->ride_date,
        ];
          
    }
}
