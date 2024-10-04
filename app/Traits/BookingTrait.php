<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

use App\Models\Booking;
use App\Models\Apartment;
use App\Models\Vehicle;
use App\Models\Bus;
use App\Models\Shuttle;

trait BookingTrait
{
    protected function storeBookable($bookableType, $bookableId, $startDate, $endDate, $bookingId, $km = null)
    {
        $booking = Booking::findOrFail($bookingId);
        if ($bookableType == 'Apartment') {
            $apartment = Apartment::findOrFail($bookableId);
            $nights = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
            $booking->apartments()->attach(
                $apartment->id,
                [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'price' => $nights * $apartment->price,
                    'status' => 'Awaiting Approval'
                ]
            );
        }
        if ($bookableType == 'Vehicle') {
            $vehicle = Vehicle::findOrFail($bookableId);
            $nights = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
            $booking->vehicles()->attach(
                $vehicle->id,
                [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'price' => $nights * $vehicle->price,
                    'status' => 'Awaiting Approval'
                ]
            );
        }
        if ($bookableType == 'Bus') {
            $bus = Bus::findOrFail($bookableId);
            $booking->buses()->attach(
                $bus->id,
                [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'price' => $km * $bus->price,
                    'status' => 'Awaiting Approval',
                    'km' => $km
                ]
            );
        }
        if ($bookableType == 'Shuttle') {
            $shuttle = Shuttle::findOrFail($bookableId);
            $booking->shuttles()->attach(
                $shuttle->id,
                [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'price' => $km * $shuttle->price,
                    'status' => 'Awaiting Approval',
                    'km' => $km
                ]
            );
        }
    }
}
