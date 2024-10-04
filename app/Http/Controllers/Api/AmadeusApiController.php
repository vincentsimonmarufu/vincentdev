<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AirportResource;
use App\Http\Resources\AirlineResource;
use App\Models\Airline;
use Illuminate\Http\Request;
use App\Models\Airport;

class AmadeusApiController extends Controller
{

    /**
     * 
     * Airports list
     * 
     */
    function myAirports(){         
        try {        

           $airports = Airport::select('airportsjson.*', 'countries.name as country_name')
           ->whereNotNull('iata')
           ->leftJoin('countries', 'airportsjson.country', '=', 'countries.code')
           ->get()
           ->map(function ($airport) {
               return [
                   'iata' => $airport->iata,
                   'name' => $airport->name,
                   'city' => $airport->city,
                   'country' => $airport->country_name ?? $airport->country,
                   'lon' => $airport->lon,
                   'lat' => $airport->lat,
               ];
           });         
           return response()->json($airports);          
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }




    function newAirports_x(){       
        try {
            $airports = Airport::all();
           if(count($airports) === 0){
            return response()->json(['message' => 'No data found']);
           }

           $airports = Airport::select('airportsjson.*', 'countries.name as country_name')
           ->whereNotNull('iata')
           ->leftJoin('countries', 'airportsjson.country', '=', 'countries.code')
           ->get()
           ->map(function ($airport) {
               return [
                   'iata' => $airport->iata,
                   'name' => $airport->name,
                   'city' => $airport->city,
                   'country' => $airport->country_name ?? $airport->country,
                   'lon' => $airport->lon,
                   'lat' => $airport->lat,
               ];
           });
           //->toArray();
           
           //return $airports;

           return response()->json(['success'=>true, 'data'=>$airports]);
           //return new AirportResource($airports);
           //return AirportResource::collection($airports);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }


    /**
     * 
     * Airlines list
     * 
     */
    function myAirlines(){       
        try {
            $airlines = Airline::all();
            //$airlines = Airline::select('id', 'name', 'code')->paginate(10);
            if(count($airlines) === 0){
                return response()->json(['message' => 'No data found']);
            }
           
           return AirlineResource::collection($airlines);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }

}
