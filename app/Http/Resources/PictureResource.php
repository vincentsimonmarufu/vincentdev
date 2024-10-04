<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class PictureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // public function toArray($request)
    // {
    //     $isApartment = $this->picture_type == 'App\\Models\\Apartment';
    //     return [
    //         'id' => $this->id,
    //         'pictureType' => $this->picture_type == 'App\\Models\\' . 'Apartment' ? 'App\\Models\\' . 'Apartment' : 'App\\Models\\' . 'Vehicle',
    //         ($isApartment ? 'apartmentId' : 'vehicleId') => $this->picture_id, // Dynamic key based on the picture type
    //         'imageName' => $this->path,
    //         'imageUrl' => $this->picture_type == 'App\\Models\\' . 'Apartment' ? asset('storage/Apartment/' . $this->path) : asset('storage/Vehicle/' . $this->path),
    //         //'created_at' => $this->created_at->format('Y-m-d H:i:s'),
    //         //'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
    //     ];
    // }

    public function toArray($request)
    {
        $isApartment = $this->picture_type == 'App\\Models\\Apartment';
        $isVehicle = $this->picture_type == 'App\\Models\\Vehicle';
        $isBus = $this->picture_type == 'App\\Models\\Bus';
        $isShuttle = $this->picture_type == 'App\\Models\\Shuttle';

        $pictureType = $isApartment ? 'App\\Models\\Apartment' : ($isVehicle ? 'App\\Models\\Vehicle' : ($isBus ? 'App\\Models\\Bus' : ($isShuttle ? 'App\\Models\\Shuttle' : '')));

        $dynamicKey = $isApartment ? 'apartmentId' : ($isVehicle ? 'vehicleId' : ($isBus ? 'busId' : ($isShuttle ? 'shuttleId' : '')));

        $imageUrl = '';
        if ($isApartment) {
            $imageUrl = asset('storage/Apartment/' . $this->path);
        } elseif ($isVehicle) {
            $imageUrl = asset('storage/Vehicle/' . $this->path);
        } elseif ($isBus) {
            $imageUrl = asset('storage/Bus/' . $this->path);
        } elseif ($isShuttle) {
            $imageUrl = asset('storage/Shuttle/' . $this->path);
        }

        return [
            'id' => $this->id,
            'pictureType' => $pictureType,
            $dynamicKey => (int)$this->picture_id, // Dynamic key based on the picture type
            'imageName' => $this->path,
            'imageUrl' => $imageUrl,
            //'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            //'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
