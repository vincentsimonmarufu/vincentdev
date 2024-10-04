<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Services\AmadeusAccessTokenService;

class GetPriceController extends Controller
{

    protected $accessTokenService;

    // added service to this controller
    public function __construct(AmadeusAccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
    }

    public function __invoke (Request $request, Client $client)
    {
        $url = 'https://test.travel.api.amadeus.com/shopping/flight-offers/pricing';        
        //$access_token = app('App\Http\Controllers\AccessTokenController')->__invoke($client)->access_token;
        $access_token = $this->accessTokenService->getAccessToken($client);

        //return $request['flight'];
        //return $access_token; 
        /*      
        $data = [
            'data' => [
                'type' => 'flight-offers-pricing',
                'flightOffers' => [
                    [
                        'type' => 'flight-offer',
                        'id' => 1,
                        'source' => 'GDS',
                        'instantTicketingRequired' => false,
                        'nonHomogeneous' => false,
                        'oneWay' => false,
                        'lastTicketingDate' => '2023-12-27',
                        'numberOfBookableSeats' => 9,
                        'itineraries' => [
                            [
                                'duration' => 'PT10H10M',
                                'segments' => [
                                    [
                                        'departure' => [
                                            'iataCode' => 'BOS',
                                            'terminal' => 'E',
                                            'at' => '2023-12-27T19:50:00'
                                        ],
                                        'arrival' => [
                                            'iataCode' => 'KEF',
                                            'at' => '2023-12-28T06:10:00'
                                        ],
                                        'carrierCode' => 'FI',
                                        'number' => '630',
                                        'aircraft' => [
                                            'code' => '76W'
                                        ],
                                        '[operating]' => [
                                            'carrierCode' => 'FI'
                                        ],
                                        'duration' => 'PT5H20M',
                                        'id' => '35',
                                        'numberOfStops' => '0',
                                        'blacklistedInEU' => false
                                    ],
                                    [
                                        'departure' => [
                                            'iataCode' => 'KEF',
                                            'at' => '2023-12-28T07:35:00'
                                        ],
                                        'arrival' => [
                                            'iataCode' => 'CDG',
                                            'terminal' => '2B',
                                            'at' => '2023-12-28T12:00:00'
                                        ],
                                        'carrierCode' => 'FI',
                                        'number' => '542',
                                        'aircraft' => [
                                            'code' => '76W'
                                        ],
                                        'operating' => [
                                            'carrierCode' => 'FI'
                                        ],
                                        'duration' => 'PT3H25M',
                                        'id' => '36',
                                        'numberOfStops' => '0',
                                        'blacklistedInEU' => false
                                    ],
                                ]
                            ]
                        ],
                        'validatingAirlineCodes' => [
                            'FI'
                        ],
                        'travelerPricings' => [
                            [
                                'travelerId' => '1',
                                'fareOption' => 'STANDARD',
                                'travelerType' => 'ADULT',
                                'price' => [
                                    'currency' => 'EUR',
                                    'total' => '482.55',
                                    'base' => '363.00'
                                ],
                                'fareDetailsBySegment' => [
                                    [
                                        'segmentId' => '35',
                                        'cabin' => 'ECONOMY',
                                        'fareBasis' => 'VJ1QUSLT',
                                        'class' => 'V',
                                        'includedCheckedBags' => [
                                            'quantity' => 0
                                        ]
                                    ],
                                    [
                                        'segmentId' => '36',
                                        'cabin' => 'ECONOMY',
                                        'fareBasis' => 'VJ1QUSLT',
                                        'brandedFare' => 'LIGHT',
                                        'class' => 'V',
                                        'includedCheckedBags' => [
                                            'quantity' => 0
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];*/

       // $data = $request->flight;

        $data = [
            'data' => [
                'type' => 'flight-offers-pricing',
                'flightOffers' => [
                    json_decode($request['flight'])
                ]
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

          //  $response = $response->getBody();
            //$response = json_decode($response, true);          
            //$response = $response->data;       

            //return view('amadeus.price')->with('data', $response->data);
            //return $response;            
        } catch (GuzzleException $exception) {
            return $exception->getMessage();
        }
    }
}
