<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Route;

class RouteDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' =>$this->id,            
            'routeName' => Route::findOrFail($this->routeid)->name,
            'routeLocations' => $this->locids,
            'routeMinutes' => $this->minutes,
            'routePrices' => $this->prices,
        ];
    }
}
