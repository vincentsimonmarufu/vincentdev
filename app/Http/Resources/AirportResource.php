<?php

namespace App\Http\Resources;

use App\Models\CountryCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class AirportResource extends JsonResource
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
            'id' => $this->id,
            'airportName' => $this->name,
            'IATA' =>$this->iata,
            'cityName' => $this->city,
            'countryName' => DB::table('countries')->where('code', $this->country)->value('name'),
            'latitude' => $this->lat,
            'longitude' =>$this->lon
        ];
    }
}
