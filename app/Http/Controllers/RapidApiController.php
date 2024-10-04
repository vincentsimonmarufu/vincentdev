<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RapidApiController extends Controller
{
   public function searchFlights()
   {

    $client = new \GuzzleHttp\Client();
    
    $response = $client->request('GET', 'https://booking-com15.p.rapidapi.com/api/v1/flights/searchFlights?fromId=HRE.AIRPORT&toId=VFA.AIRPORT&departDate=2023-11-29&pageNo=1&adults=1', [
        'headers' => [
            'X-RapidAPI-Host' => 'booking-com15.p.rapidapi.com',
            'X-RapidAPI-Key' => 'c474505e78msh7437d74a19fb568p16b13cjsn51596d825f1a',
        ],
    ]);
    
      //  echo $response->getBody();

      
    $data = json_decode($response->getBody(), true);
      //  dd($data);
    // Check if 'data' and 'airlines' keys are present
    return view('flightapi.rapidresults', ['flights' => $data]);

   }
   public function searchMultiStops()
   {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://booking-com15.p.rapidapi.com/api/v1/flights/searchFlightsMultiStops?', [
            'headers' => [
                'X-RapidAPI-Host' => 'booking-com15.p.rapidapi.com',
                'X-RapidAPI-Key' => 'c474505e78msh7437d74a19fb568p16b13cjsn51596d825f1a',
            ],
        ]);

        echo $response->getBody();
      
        $data = json_decode($response->getBody(), true);
            dd($data);
        // Check if 'data' and 'airlines' keys are present
        if (isset($data['data']['airlines'])) {
            return view('flightapi.rapidresults', ['flights' => $data]);
        } else {
            // Handle the case where the expected structure is not present
            return view('flightapi.rapidresults', ['flights' => null]);
        }

   }
}
