<?php 

// Airport name using iata code
if (!function_exists('airportName')) {
    function airportName($iata) {
        $airport = \App\Models\Airport::where('iata', $iata)->first();

        if ($airport) {
            return $airport->name;
        }
        return null;
    }
}

// Airline name using airline code
if (!function_exists('airlineName')) {
    function airlineName($code) {
        $airline = \App\Models\Airline::where('code', $code)->first();

        if ($airline) {
            return $airline->name;
        }
        return null;
    }
}





