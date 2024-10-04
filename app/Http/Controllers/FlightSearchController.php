<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Airport;

class FlightSearchController extends Controller
{
  /*  public function __invoke (Request $request, Client $client)
    {
        $url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
        $access_token = 'Nw0e00XJqvikB9Z5Zo5i1nDMEmWw';

        $data = [
            'originDestinations' => [
                [
                    'id' => 1,
                    'originLocationCode' => 'HRE',
                    'destinationLocationCode' => 'VFA',
                    'departureDateTimeRange' => [
                        'date' => '2023-12-27'
                    ]
                ],
                [
                    'id' => 2,
                    'originLocationCode' => 'VFA',
                    'destinationLocationCode' => 'HRE',
                    'departureDateTimeRange' => [
                        'date' => '2023-12-30'
                    ]
                ]
            ],
            'travelers' => [
                [
                    'id' => 1,
                    'travelerType' => 'ADULT'
                ]
            ],
            'sources' => [
                'GDS'
            ],
            "currencyCode" => "USD",
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token
                ],
                'json' => $data
            ]);


            $response = $response->getBody();
            $response = json_decode($response);

            return view('amadeus.index')->with('flights', $response->data);
        } catch (GuzzleException $exception) {
            return $exception;
        }
    }
    */
    public function __invoke (Request $request, Client $client)
    {
        $url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
        $access_token = app('App\Http\Controllers\AccessTokenController')->__invoke($client)->access_token;
       

        $travelers = [];

       /* for ($i = 1; $i <= $request['passengers']; $i++) {
            $travelers[] = [
                'id' => $i,
                'travelerType' => 'ADULT'
            ];
        }*/
       
        $data = [
            'originDestinations' => [
                [
                    'id' => 1,
                    'originLocationCode' => 'BOS',
                    'destinationLocationCode' => 'KEF',
                    'departureDateTimeRange' => [
                        'date' => '2023-12-28'
                    ]
                ]
            ],
            'travelers' => [
                [
                    'id' => 1,
                    'travelerType' => 'ADULT'
                ]
            ],
            "currencyCode" => "USD",
            'sources' => [
                'GDS'
            ]
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token
                ],
                'json' => $data
            ]);

            $response = $response->getBody();
            $response = json_decode($response);
            
            return view('amadeus.index')->with('flights', $response->data);
        } catch (GuzzleException $exception) {
            return $exception;
        }
    }
    public function index ()
    {
        return view('amadeus.search');
    }
    public function autocomplete(Request $request)
    {
        $query = $request->input('q');
        $airports = Airport::where('name', 'like', "%$query%")
        ->orWhere('iata', 'like', "%$query%")
        ->orWhere('city', 'like', "%$query%")
        ->orWhere('country', 'like', "%$query%")
        ->get();
    
        return response()->json($airports);
    }
}
