<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class KiwiFlightController extends Controller
{
    public function searchFlights(Request $request)
    {
        $oneway = '2crnQvoN9BRyum42iqZiXuTvT7U7_kwn'; // Replace with your Kiwi.com API key
        $multicity = 'CgYWQZrYI84bs60bp754_aPFgviyML2F'; // Replace with your Kiwi.com API key
        $nomad = '-_IJ1UDEmz4zEJp8D3ngqoT_Sp4gBhxK'; // Replace with your Kiwi.com API key

        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $date = $request->input('date');

        $client = new Client();

        if($request->input('type') == 'nomad')
        {
            $response = $client->get("https://tequila-api.kiwi.com/v2/search", [
                'headers' => [
                    'apikey' => $nomad,
                ],
                'query' => [
                    'fly_from' => $origin,
                    'fly_to' => $destination,
                    'date_from' => $date,
                ],
            ]);
        }
        elseif($request->input('type') == 'multicity')
        {
            $response = $client->get("https://api.tequila.kiwi.com/v2/flights_multi", [
                'headers' => [
                    'apikey' => $multicity,
                ],
                'query' => [
                    'fly_from' => $origin,
                    'fly_to' => $destination,
                    'date_from' => $date,
                ],
            ]);
        }else{
            $response = $client->get("https://tequila-api.kiwi.com/v2/search", [
                'headers' => [
                    'apikey' => $oneway,
                ],
                'query' => [
                    'fly_from' => $origin,
                    'fly_to' => $destination,
                    'date_from' => $date,
                ],
            ]);

        }
        

        $data = json_decode($response->getBody(), true);
        //dd($data);
        // Pass the data to the Blade view
        return view('flightapi.results', ['flights' => $data['data']]);
    }
}
