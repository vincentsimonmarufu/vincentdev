<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Apartment;
use App\Models\Shuttle;
use App\Models\Vehicle;
use App\Models\Bus;
use App\Models\Airport;
use App\Models\Busloc;
use App\Models\CountryCode;
use Illuminate\Http\Request;
use App\Notifications\ContactUs;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use App\Models\ContactUs as Contact;
use App\Services\AmadeusAccessTokenService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;
use App\Models\Route;
use App\Models\Visitor;
use Illuminate\Support\Facades\Redis;
use App\Services\AmadeusConfig;
use Illuminate\Support\Facades\Validator;
use ReCaptcha\ReCaptcha;


class WelcomeController extends Controller
{

    protected $accessTokenService;
    protected $amaClientRef;
    protected $airports;

    // added service to this controller
    public function __construct(AmadeusAccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
    }

    public function serverdown()
    {
        return view('serverdown');
    }

    public function welcome()
    {
        $apartments = Apartment::where('status', 'active')->inRandomOrder()->limit(6)->get();
        $vehicles = Vehicle::where('status', 'active')->inRandomOrder()->limit(6)->get();
        $cities = Apartment::select('city as name')->distinct()->get();
        return view('welcome', compact('apartments', 'cities', 'vehicles'));
    }

    public function about()
    {
        return view('about');
    }

    public function privacy()
    {
        return view('privacy');
    }

    // public function flight()
    // {
    //     return view('flight');
    // }

    /**
     * list of countries
     *
     */
    public function countrycode()
    {

        $jsonPath = public_path('CountryCodes.json');

        if (File::exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);

            $codes = json_decode($jsonContent, true);

            foreach ($codes as $codeData) {
                // Create a new country record
                $code = new CountryCode;
                $code->dial_code = $codeData['dial_code'];
                $code->name = $codeData['name'];
                $code->code = $codeData['code'];
                $code->save();
            }
            return $codes;
        }

        $codes = CountryCode::all();

        return $codes;
    }


    /**
     * list of airline's using local file/abisiniya database
     *
     */
    function airlines()
    {
        // Get the path to the JSON file
        $jsonPath = public_path('airlines.json');

        // Check if the file exists
        if (File::exists($jsonPath)) {
            // Read the JSON file content
            $jsonContent = file_get_contents($jsonPath);

            // Decode the JSON content
            $airlines = json_decode($jsonContent, true);
            // Loop through each airport in the array
            foreach ($airlines as $airportData) {
                // Create a new airport record
                // Check if both 'name' and 'iata' are set and not null
                if (
                    isset($airportData['name']) && $airportData['name'] !== null && $airportData['name'] !== "" &&
                    isset($airportData['code']) && $airportData['code'] !== null && $airportData['code'] !== ""
                ) {

                    $airline = new Airline();
                    $airline->code = $airportData['code'];
                    $airline->name = $airportData['name'];
                    $airline->logo = $airportData['logo'];
                    // Save each airport record

                    $airline->save();
                }
            }
            return $airlines;
        }


        $airlines = Airline::all();//->toArray();

        return $airlines;
    }


    /**
     * list of airport's using local file/ abisiniya database
     *
     */
    //function airports()
    function loadAirports()
    {
        // Get the path to the JSON file
        $jsonPath = public_path('airports.json');

        // Check if the file exists
        if (File::exists($jsonPath)) {
            // Read the JSON file content
            $jsonContent = file_get_contents($jsonPath);

            // Decode the JSON content
            $airports = json_decode($jsonContent, true);
            // Loop through each airport in the array
            foreach ($airports as $airportData) {
                // Create a new airport record
                // Check if both 'name' and 'iata' are set and not null
                if (
                    isset($airportData['name']) && $airportData['name'] !== null && $airportData['name'] !== "" &&
                    isset($airportData['iata']) && $airportData['iata'] !== null && $airportData['iata'] !== "" && $airportData['iata'] !== " " && $airportData['iata'] !== Null
                ) {
                    $airport = new Airport;
                    $airport->iata = $airportData['iata'];
                    $airport->name = $airportData['name'];
                    $airport->city = $airportData['city'];
                    $airport->country = $airportData['country'];
                    $airport->lon = $airportData['lon'];
                    $airport->lat = $airportData['lat'];
                    // Save each airport record
                    $airport->save();
                }
            }
            return $airports;
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
            })
            ->toArray();

        return $airports;
    }


    // Method to fetch and initialize the airports list lazily
    protected function getAirports()
    {
        if (is_null($this->airports)) {
            $this->airports = $this->loadAirports();
        }
        return $this->airports;
    }


    /**
     * function to show flight search form
     *
     */
    function index()
    {
        //$airports = $this->airports();
        $userMessage = '';

        // Access the lazy-loaded airports list
        $airports = $this->getAirports();
        //return $airports;
        return view('amadeus.search', compact('airports', 'userMessage'));
    }


    function multicity()
    {
        //$airports = $this->airports();
        // Access the lazy-loaded airports list
        $airports = $this->getAirports();
        return view('amadeus.multicity', compact('airports'));
    }


    // flight search for one-way and round-trip
    function flightsearch(Request $request, Client $client)
    {
        $url = 'https://test.travel.api.amadeus.com/v2/shopping/flight-offers';
        $access_token = $this->accessTokenService->getAccessToken($client);

        //return $access_token;
        $adultsCount = $request->adults;
        $childrenCount = $request->children;
        $infantsCount = $request->infants;
        $travelers = [];

        // Add adult
        for ($i = 1; $i <= $adultsCount; $i++) {
            $travelers[] = [
                'id' => $i,
                'travelerType' => 'ADULT'
            ];
        }

        //Add children
        for ($i = 1; $i <= $childrenCount; $i++) {
            $travelers[] = [
                'id' => $adultsCount + $i,
                'travelerType' => 'CHILD',
                'age' => 11
            ];
        }

        //Add infants
        for ($i = 1; $i <= $infantsCount; $i++) {
            $travelers[] = [
                'id' => $adultsCount + $childrenCount + $i,
                'travelerType' => 'HELD_INFANT',
                'age' => 1,
                'associatedAdultId' => $i
            ];
        }

        //return count($travelers);

        if ($request->flight_option == 'return') {
            $data = [
                'originDestinations' => [
                    [
                        'id' => 1,
                        'originLocationCode' => $request->origin,
                        'destinationLocationCode' => $request->destination,
                        'departureDateTimeRange' => [
                            'date' => Carbon::parse($request->departure_date)->format('Y-m-d')
                        ]
                    ],
                    [
                        'id' => 2,
                        'originLocationCode' => $request->destination, // Swap origin and destination for return
                        'destinationLocationCode' => $request->origin,
                        'departureDateTimeRange' => [
                            'date' => $request->return_date // Use return date for the departureDateTimeRange
                        ]
                    ]
                ],

                'travelers' => $travelers,
                'currencyCode' => $request->currency,
                'sources' => ['GDS'],
                'sort' => 'price',
                'searchCriteria' => [
                    //'maxFlightOffers' => 1,
                    'flightFilters' => [
                        'cabinRestrictions' => [
                            [
                                'cabin' => $request->cabin,
                                'coverage' => 'MOST_SEGMENTS',
                                'originDestinationIds' => [1, 2],
                            ],
                        ],
                    ],
                    // "additionalInformation" => [
                    //     "includedCheckedBagsOnly" => true
                    // ]
                ]
            ];
        } else {
            $data = [
                'originDestinations' => [
                    [
                        'id' => 1,
                        'originLocationCode' => $request->origin,
                        'destinationLocationCode' => $request->destination,
                        'departureDateTimeRange' => [
                            'date' => Carbon::parse($request->departure_date)->format('Y-m-d')
                        ]
                    ]
                ],

                'travelers' => $travelers,
                'currencyCode' => $request->currency,
                'sources' => ['GDS'],
                'sort' => 'price',
                'searchCriteria' => [
                    //'maxFlightOffers' => 1,
                    "instantTicketingRequired" => false,
                    'flightFilters' => [
                        'cabinRestrictions' => [
                            [
                                'cabin' => $request->cabin,
                                'coverage' => 'MOST_SEGMENTS',
                                'originDestinationIds' => [1],
                            ],
                        ],
                    ]
                ]
            ];
        }

        $airports = $this->getAirports();
        $amaClientRef = Carbon::now()->toIso8601ZuluString('microsecond');
        //Log::info('ama-client-ref-try-before-api hit: ' . $amaClientRef);
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token,
                    'ama-client-ref' => $amaClientRef,
                ],
                'json' => $data
            ]);

            Log::info('flight-offer called successfully...');
            $amaRequestId = $response->getHeader('ama-request-id')[0] ?? 'Not available';
            $amaClientRef = $response->getHeader('ama-client-ref')[0] ?? 'Not available';
            $rateLimit = $response->getHeader('X-RateLimit-Limit')[0] ?? 'Not available';

            Log::info('ama-request-id-try: ' . $amaRequestId);
            Log::info('ama-client-ref-try: ' . $amaClientRef);
            Log::info('X-RateLimit-Limit-try: ' . $rateLimit);

            $response = $response->getBody();
            //return $response;
            $response = json_decode($response);
            $flights = $response->data;
            $flight_option = $request->flight_option;
            //return $response;
            return view('amadeus.search', compact('flights', 'airports', 'flight_option'));
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $amaRequestId = $e->getResponse()->getHeader('ama-request-id')[0] ?? 'Not available';
                $amaClientRef = $e->getResponse()->getHeader('ama-client-ref')[0] ?? 'Not available';
                $rateLimit = $e->getResponse()->getHeader('X-RateLimit-Limit')[0] ?? 'Not available';
                //$rateRemaining = $e->getResponse()->getHeader('X-RateLimit-Remaining') ?? 'Not available';
                $errorResponse = $e->getResponse()->getBody()->getContents();

                Log::error('ama-request-id: ' . $amaRequestId);
                Log::error('ama-client-ref: ' . $amaClientRef);
                Log::error('request error: ' . $errorResponse);
                Log::error('X-RateLimit-Limit: ' . $rateLimit);
                //Log::error('X-RateLimit-Remaining: ' . $rateRemaining);

            } else {
                Log::error('request error:else ' . $e->getMessage());
                //echo 'Request Error: ' . $e->getMessage();
                return view('amadeus.search', compact('airports'))
                    ->with(['exception' => $e->getMessage()]);
            }
        }
    }


    // flight search for one-way and round-trip
    // function flightsearch_working(Request $request, Client $client)
    // {
    //     //return $request->all();
    //     //$url = 'https://test.api.amadeus.com/v2/shopping/flight-offers';
    //     $url = 'https://test.travel.api.amadeus.com/v2/shopping/flight-offers';
    //     $access_token = $this->accessTokenService->getAccessToken($client);
    //     //return $access_token;
    //     $adultsCount = $request->adults;
    //     $childrenCount = $request->children;
    //     $infantsCount = $request->infants;
    //     $travelers = [];

    //     // Add adult
    //     for ($i = 1; $i <= $adultsCount; $i++) {
    //         $travelers[] = [
    //             'id' => $i,
    //             'travelerType' => 'ADULT'
    //         ];
    //     }

    //     //Add children
    //     for ($i = 1; $i <= $childrenCount; $i++) {
    //         $travelers[] = [
    //             'id' => $adultsCount + $i,
    //             'travelerType' => 'CHILD',
    //             'age' => 11
    //         ];
    //     }

    //     //Add infants
    //     for ($i = 1; $i <= $infantsCount; $i++) {
    //         $travelers[] = [
    //             'id' => $adultsCount + $childrenCount + $i,
    //             'travelerType' => 'HELD_INFANT',
    //             'age' => 1,
    //             'associatedAdultId' => $i
    //         ];
    //     }


    //     if ($request->flight_option == 'return') {
    //         $data = [
    //             'originDestinations' => [
    //                 [
    //                     'id' => 1,
    //                     'originLocationCode' => $request->origin,
    //                     'destinationLocationCode' => $request->destination,
    //                     'departureDateTimeRange' => [
    //                         'date' => Carbon::createFromFormat('Y-m-d', $request->departure_date)->format('Y-m-d')
    //                     ]
    //                 ],
    //                 [
    //                     'id' => 2,
    //                     'originLocationCode' => $request->destination, // Swap origin and destination for return
    //                     'destinationLocationCode' => $request->origin,
    //                     'departureDateTimeRange' => [
    //                         'date' => $request->return_date // Use return date for the departureDateTimeRange
    //                     ]
    //                 ]
    //             ],

    //             'travelers' => $travelers,
    //             'currencyCode' => $request->currency,
    //             'sources' => ['GDS'],
    //             'sort' => 'price',
    //             'searchCriteria' => [
    //                 //'maxFlightOffers' => 1,
    //                 'flightFilters' => [
    //                     'cabinRestrictions' => [
    //                         [
    //                             'cabin' => $request->cabin,
    //                             'coverage' => 'MOST_SEGMENTS',
    //                             'originDestinationIds' => [1, 2],
    //                         ],
    //                     ],
    //                 ],
    //                 // "additionalInformation" => [
    //                 //     "includedCheckedBagsOnly" => true
    //                 // ]
    //             ]
    //         ];
    //     } else {
    //         $data = [
    //             'originDestinations' => [
    //                 [
    //                     'id' => 1,
    //                     'originLocationCode' => $request->origin,
    //                     'destinationLocationCode' => $request->destination,
    //                     'departureDateTimeRange' => [
    //                         'date' => Carbon::createFromFormat('Y-m-d', $request->departure_date)->format('Y-m-d')
    //                     ]
    //                 ]
    //             ],

    //             'travelers' => $travelers,
    //             'currencyCode' => $request->currency,
    //             'sources' => ['GDS'],
    //             'sort' => 'price',
    //             'searchCriteria' => [
    //                 //'maxFlightOffers' => 1,
    //                 "instantTicketingRequired" => false,
    //                 'flightFilters' => [
    //                     'cabinRestrictions' => [
    //                         [
    //                             'cabin' => $request->cabin,
    //                             'coverage' => 'MOST_SEGMENTS',
    //                             'originDestinationIds' => [1],
    //                         ],
    //                     ],
    //                 ],
    //                 // "additionalInformation" => [
    //                 //    "includedCheckedBagsOnly" => true
    //                 // ]
    //             ]
    //         ];
    //     }
    //     //return $data;
    //     $airports = $this->getAirports();
    //     // Generate a random UUID
    //     $amaClientRef = Carbon::now()->toIso8601ZuluString('microsecond');
    //     try {
    //         $response = $client->post($url, [
    //             'headers' => [
    //                 'Accept' => 'application/json',
    //                 'Authorization' => 'Bearer ' . $access_token,
    //                 'ama-client-ref' => $amaClientRef,
    //             ],
    //             'json' => $data
    //         ]);

    //         //return $response

    //         $amaRequestId = $response->getHeader('ama-request-id')[0] ?? 'Not available';
    //         $amaClientRef = $response->getHeader('ama-client-ref')[0] ?? 'Not available';
    //         $rateLimit = $response->getHeader('X-RateLimit-Limit')[0] ?? 'Not available';
    //         //$rateRemaining = $response->getHeader('X-RateLimit-Remaining') ?? 'Not available';
    //         Log::info('ama-request-id: ' . $amaRequestId);
    //         Log::info('ama-client-ref: ' . $amaClientRef);
    //         Log::info('X-RateLimit-Limit: ' . $rateLimit);
    //         //Log::info('X-RateLimit-Remaining: ' . $rateRemaining);

    //         $response = $response->getBody();

    //         //return $response;
    //         $response = json_decode($response);
    //         $flights = $response->data;
    //         $flight_option = $request->flight_option;
    //         //return $flights;
    //         return view('amadeus.search', compact('flights', 'airports', 'flight_option'));
    //     } catch (RequestException $e) {
    //         if ($e->hasResponse()) {
    //             $amaRequestId = $e->getResponse()->getHeader('ama-request-id')[0] ?? 'Not available';
    //             $amaClientRef = $e->getResponse()->getHeader('ama-client-ref')[0] ?? 'Not available';
    //             $rateLimit = $e->getResponse()->getHeader('X-RateLimit-Limit')[0] ?? 'Not available';
    //             //$rateRemaining = $e->getResponse()->getHeader('X-RateLimit-Remaining') ?? 'Not available';
    //             $errorResponse = $e->getResponse()->getBody()->getContents();

    //             Log::error('ama-request-id: ' . $amaRequestId);
    //             Log::error('ama-client-ref: ' . $amaClientRef);
    //             Log::error('request error: ' . $errorResponse);
    //             Log::error('X-RateLimit-Limit: ' .  $rateLimit);
    //             //Log::error('X-RateLimit-Remaining: ' . $rateRemaining);

    //         } else {
    //             Log::error('request error:else ' . $e->getMessage());
    //             //echo 'Request Error: ' . $e->getMessage();
    //             return view('amadeus.search', compact('airports'))
    //             ->with(['exception' => $e->getMessage()]);
    //         }
    //     }
    // }


    //flight seatmap selection implementation
    public function flightSeatMap(Request $request, Client $client)
    {
        $url = 'https://test.travel.api.amadeus.com/v1/shopping/seatmaps';
        $access_token = $this->accessTokenService->getAccessToken($client);
        $flightOfferId = $request->offerId;
        $flight_option = $request->flight_option;
        $flightOfferDetail = json_decode($request['flight']);
        $amaClientRef = Carbon::now()->toIso8601ZuluString('microsecond');
        $travelerCount = count($flightOfferDetail->travelerPricings); // $flightOfferDetail[0]['decks'][0]['deckConfiguration']
        //var_dump($travelerCount); die;
        try {
            $body = [
                'data' => [
                    $flightOfferDetail
                ]
            ];

            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                    'Content-Type' => 'application/json',
                    'ama-client-ref' => $amaClientRef,
                ],
                'json' => $body
            ]);

            Log::info('seatMap-display called successfully...');

            //return $response;
            $amaRequestId = $response->getHeader('ama-request-id')[0] ?? 'Not available';
            $amaClientRef = $response->getHeader('ama-client-ref')[0] ?? 'Not available';
            $rateLimit = $response->getHeader('X-RateLimit-Limit')[0] ?? 'Not available';
            //$rateRemaining = $response->getHeader('X-RateLimit-Remaining') ?? 'Not available';
            Log::info('ama-request-id: ' . $amaRequestId);
            Log::info('ama-client-ref: ' . $amaClientRef);
            Log::info('X-RateLimit-Limit: ' . $rateLimit);

            // if (!empty($response)) {
            //     // Check if response exists
            //     $statusCode = $response->getStatusCode(); // Should return 200, 404, etc.
            //     Log::info('Status code: ' . $statusCode);

            //     $responseBody = $response->getBody();
            //     //$data = json_decode($responseBody, true);
            //     $seatMapData1 = json_decode($responseBody, true);
            //     Log::info('Response body:', $seatMapData1);
            //     $seatMapData = $seatMapData1['data'];
            //     $deckConfiguration = $seatMapData[0]['decks'][0]['deckConfiguration'];
            //     $metaCount = $seatMapData1['meta']['count'];
            //     return view('flightseatmap', compact('seatMapData', 'flightOfferId', 'flightOfferDetail', 'deckConfiguration', 'flight_option','metaCount'));
            // }
            // if(isset($response->errors)){
            //     return 'seatmap data not available';
            // }
            $responseBody = $response->getBody();
            $seatMapData1 = json_decode($responseBody, true);
            Log::info('count:', $seatMapData1);
            Log::info('Response body:', $seatMapData1);

            //return $seatMapData1;

            $seatMapData = $seatMapData1['data'];
            $deckConfiguration = $seatMapData[0]['decks'][0]['deckConfiguration'];
            $metaCount = $seatMapData1['meta']['count'];
            return view('flightseatmap', compact('seatMapData', 'flightOfferId', 'flightOfferDetail', 'deckConfiguration', 'flight_option', 'metaCount', 'travelerCount'));


            // if (isset($response->errors)) {
            //     Log::error('API Error: ' . json_encode($response->errors));
            //     echo 'API Error: ' . json_encode($response->errors);
            // } else {
            //     return view('flightseatmap', compact('seatMapData', 'flightOfferId', 'flightOfferDetail', 'deckConfiguration', 'flight_option','metaCount'));
            // }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorResponse = $e->getResponse();
                $errorStatusCode = $errorResponse->getStatusCode();
                $errorBody = json_decode($errorResponse->getBody()->getContents(), 'true');

                Log::error('Request failed with status in catch: ' . $errorStatusCode);
                Log::error('errorBody');
                Log::error($errorBody);
                //echo "<pre>"; print_r($errorBody);

                if ($errorBody['errors'][0]['status'] == '400') {

                    if ($errorBody['errors'][0]['code'] == '14498') {
                        Log::error('Error details: in catch ' . $errorBody['errors'][0]['code']);
                        //need to call flight-price api  return redirect()->route('flight-price')
                        //return redirect('flight-price')->with('flightoption', $flight_option)->with('flightoffer', $flightOfferDetail);
                        return redirect()->route('flight-price')->with('flightoption', $flight_option)->with('flightoffer', json_encode($flightOfferDetail));
                    }

                    if ($errorBody['errors'][0]['code'] == '4926') {
                        Log::error('Error details: in catch ' . $errorBody['errors'][0]['code']);
                        //need to call flight-price api  return redirect()->route('flight-price')
                        //return redirect('flight-price')->with('flightoption', $flight_option)->with('flightoffer', $flightOfferDetail);
                        $userMessage = $errorBody['errors'][0]['detail'];
                        return redirect()->route('flights.searching')->with('userMessage', $userMessage);
                    }

                    // if($errorBody['errors'][0]['code'] == '34651'){
                    //     Log::error('Error details: in catch ' . $errorBody['errors'][0]['code']);
                    //     //need to call flight-price api  return redirect()->route('flight-price')
                    //     //return redirect('flight-price')->with('flightoption', $flight_option)->with('flightoffer', $flightOfferDetail);
                    //     $userMessage = $errorBody['errors'][0]['title'];
                    //     return redirect()->route('flights.searching')->with('userMessage', $userMessage);
                    // }
                }

                if ($errorBody['errors'][0]['status'] == '500') {
                    Log::error('Error details: in catch with seatmap ' . $errorBody['errors'][0]['title']);
                }

            } else {
                Log::error('Request failed: in catch' . $e->getMessage());
            }
        }

    } //end flightSeatMap


    // flight price implementation
    public function flightprice(Request $request, Client $client)
    {
        //$flight_option = session('flightoption');
        //$flightOffer = session('flightoffer');
        $flight_option = $request->flight_option ?? session('flight_option');
        $flightOffer = json_decode($request['flight'], true) ?? json_decode(session('flightoffer'), true);
        $selectedSeats = $request->input('selectedSeats')[0] ?? '';


        //return ['flight_option' => $flight_option, 'flightOffer'=> $flightOffer, 'selectedSeats'=> $selectedSeats];

        $seatArray = explode(",", $selectedSeats);    // working
        //return $flightOffer;
        /*foreach ($flightOffer['travelerPricings'][0]['fareDetailsBySegment'] as $key => $segment) {
            //print_r($flightOffer['travelerPricings'][0]['fareDetailsBySegment'][1]);
            //if (isset($seatArray[$key])) {
                $flightOffer['travelerPricings'][0]['fareDetailsBySegment'][$key]['additionalServices'] = [
                    'chargeableSeatNumber' => $seatArray[$key]
                ];
            //}
            //echo $key;
        } */

        // foreach ($flightOffer['travelerPricings'] as $key => $travelerPricing) {
        //     foreach ($travelerPricing['fareDetailsBySegment'] as $segmentKey => $segment) {
        //         $flightOffer['travelerPricings'][$key]['fareDetailsBySegment'][$segmentKey]['additionalServices'] = [
        //             'chargeableSeatNumber' => $seatArray[$key]
        //         ];
        //     }
        // }

        foreach ($flightOffer['travelerPricings'] as $key => $travelerPricing) {
            foreach ($travelerPricing['fareDetailsBySegment'] as $segmentKey => $segment) {
                // checking for amenities
                if (!empty($segment['amenities'])) {
                    foreach ($segment['amenities'] as $amenities) {
                        Log::info('amenityType -->' . $amenities['amenityType']);
                        if ($amenities['amenityType'] == 'PRE_RESERVED_SEAT') {
                            $flightOffer['travelerPricings'][$key]['fareDetailsBySegment'][$segmentKey]['additionalServices'] = [
                                'chargeableSeatNumber' => $seatArray[$key]
                            ];
                        }
                    }
                }
            }
        }

        // foreach ($flightOffer['travelerPricings'] as $key => $travelerPricing) {
        //     foreach ($travelerPricing['fareDetailsBySegment'] as $segmentKey => $segment) {
        //         // Check if 'amenities' exist and are not empty
        //         if (!empty($segment['amenities'])) {
        //             // Search for the specific amenity type 'PRE_RESERVED_SEAT'
        //             $preReservedSeat = array_filter($segment['amenities'], function ($amenity) {
        //                 Log::info('amenityType -->' . $amenity['amenityType']);
        //                 return $amenity['amenityType'] === 'PRE_RESERVED_SEAT';
        //             });

        //             // If 'PRE_RESERVED_SEAT' found, add 'additionalServices'
        //             if (!empty($preReservedSeat)) {
        //                 $flightOffer['travelerPricings'][$key]['fareDetailsBySegment'][$segmentKey]['additionalServices'] = [
        //                     'chargeableSeatNumber' => $seatArray[$key]
        //                 ];
        //             }
        //         }
        //     }
        // }

        //return $flightOffer;
        try {
            $countries = $this->countrycode();
            $airports = $this->getAirports();
            //$url = 'https://test.api.amadeus.com/v1/shopping/flight-offers/pricing';
            $url = 'https://test.travel.api.amadeus.com/v1/shopping/flight-offers/pricing';

            $access_token = $this->accessTokenService->getAccessToken($client);
            $userData = [
                'data' => [
                    'type' => 'flight-offers-pricing',
                    'flightOffers' => [
                        $flightOffer
                    ]
                ]
            ];

            $amaClientRef = Carbon::now()->toIso8601ZuluString('microsecond');

            $response = $client->post($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token,
                    'ama-client-ref' => $amaClientRef,
                ],
                'json' => $userData
            ]);


            $response = $response->getBody();
            //return $response;
            $data = json_decode($response)->data;
            //return $data;
            //return $data;
            //$data = $responseNew;
            if (isset($response->errors)) {
                Log::error('API Error: ' . json_encode($response->errors));
                echo 'API Error: ' . json_encode($response->errors);
            } else {
                return view('flightprice', compact('countries', 'data', 'flight_option'));
            }
        } catch (ClientException $e) {

            // Extract headers
            $amaRequestId = $e->getResponse()->getHeader('Ama-Request-Id')[0] ?? 'Not available';
            $amaClientRef = $e->getResponse()->getHeader('Ama-Client-Ref')[0] ?? 'Not available';

            // Extract and decode the error response body
            $errorResponse = $e->getResponse()->getBody()->getContents();
            $errorData = json_decode($errorResponse, true);

            // Log detailed error information
            Log::error('Ama-Request-Id: ' . $amaRequestId);
            Log::error('Ama-Client-Ref: ' . $amaClientRef);
            Log::error('Request Error: ' . $errorResponse);

            // Provide user-friendly message based on error code
            $userMessage = 'An unexpected error occurred. Please try again later.';
            if (isset($errorData['errors']) && is_array($errorData['errors'])) {
                foreach ($errorData['errors'] as $error) {
                    switch ($error['code']) {
                        case 34651: // Segment sell failure
                            $userMessage = 'Could not sell the flight segment. Please check the flight details and try again.';
                            break;
                        case 4926: // Segment sell failure
                            $userMessage = $error['title'];
                            break;
                        // Add more cases as needed
                        default:
                            $userMessage = 'An unexpected error occurred. Please try again later.';
                            break;
                    }
                }
            }

            // Return error view with user-friendly message
            //return view('error', ['message' => $userMessage]);
            return view('amadeus.search', compact('airports', 'userMessage'));
            //->with(['message' => $userMessage]);
            //echo $userMessage;
        }
    }


    // flight price implementation
    // public function flightprice_working(Request $request, Client $client)
    // {
    //     //$request->all();
    //     $flight_option = $request->flight_option;
    //     try {
    //         $countries = $this->countrycode();
    //         // Access the lazy-loaded airports list
    //         $airports = $this->getAirports();
    //         //$url = 'https://test.api.amadeus.com/v1/shopping/flight-offers/pricing';
    //         $url = 'https://test.travel.api.amadeus.com/v1/shopping/flight-offers/pricing';

    //         $access_token = $this->accessTokenService->getAccessToken($client);
    //         $userData = [
    //             'data' => [
    //                 'type' => 'flight-offers-pricing',
    //                 'flightOffers' => [
    //                     json_decode($request['flight'])
    //                 ]
    //             ]
    //         ];

    //         // Log the data being sent
    //         //Log::info('Request data: ' . json_encode($data));
    //         $response = $client->post($url, [
    //             'headers' => [
    //                 'Accept' => 'application/json',
    //                 'Authorization' => 'Bearer ' . $access_token,
    //                 'Ama-Client-Ref' => $this->amaClientRef,
    //             ],
    //             'json' => $userData
    //         ]);

    //         $response = $response->getBody();
    //         $data = json_decode($response)->data;
    //         //return $data;
    //         //$data = $responseNew;
    //         if (isset($response->errors)) {
    //             Log::error('API Error: ' . json_encode($response->errors));
    //             echo 'API Error: ' . json_encode($response->errors);
    //         } else {
    //             return view('flightprice', compact('countries', 'data', 'flight_option'));
    //         }
    //     } catch (ClientException $e) {

    //         //$countries = $this->countrycode();
    //         // Access the lazy-loaded airports list
    //         //$airports = $this->getAirports();

    //         // Extract headers
    //          $amaRequestId = $e->getResponse()->getHeader('Ama-Request-Id')[0] ?? 'Not available';
    //          $amaClientRef = $e->getResponse()->getHeader('Ama-Client-Ref')[0] ?? 'Not available';

    //          // Extract and decode the error response body
    //          $errorResponse = $e->getResponse()->getBody()->getContents();
    //          $errorData = json_decode($errorResponse, true);

    //          // Log detailed error information
    //          Log::error('Ama-Request-Id: ' . $amaRequestId);
    //          Log::error('Ama-Client-Ref: ' . $amaClientRef);
    //          Log::error('Request Error: ' . $errorResponse);

    //          // Provide user-friendly message based on error code
    //          $userMessage = 'An unexpected error occurred. Please try again later.';
    //          if (isset($errorData['errors']) && is_array($errorData['errors'])) {
    //              foreach ($errorData['errors'] as $error) {
    //                  switch ($error['code']) {
    //                      case 34651: // Segment sell failure
    //                          $userMessage = 'Could not sell the flight segment. Please check the flight details and try again.';
    //                          break;
    //                      // Add more cases as needed
    //                      default:
    //                          $userMessage = 'An unexpected error occurred. Please try again later.';
    //                          break;
    //                  }
    //              }
    //          }

    //          // Return error view with user-friendly message
    //          //return view('error', ['message' => $userMessage]);
    //          return view('amadeus.search', compact('airports','userMessage'));
    //          //->with(['message' => $userMessage]);
    //          //echo $userMessage;
    //     }
    // }


    // flightoffer search for multi-city
    public function flightmulticitysearch(Request $request, Client $client)
    {
        //$client = new Client();
        $url = 'https://test.travel.api.amadeus.com/v2/shopping/flight-offers';
        $access_token = $this->accessTokenService->getAccessToken($client);

        $adultsCount = $request->adults;
        $childrenCount = $request->children;
        $infantsCount = $request->infants;

        $travelers = [];

        // Add adults
        for ($i = 1; $i <= $adultsCount; $i++) {
            $travelers[] = [
                'id' => $i,
                'travelerType' => 'ADULT'
            ];
        }

        // Add children
        for ($i = 1; $i <= $childrenCount; $i++) {
            $travelers[] = [
                'id' => $adultsCount + $i,
                'travelerType' => 'CHILD',
                'age' => 12
            ];
        }

        // Add infants
        for ($i = 1; $i <= $infantsCount; $i++) {
            // Assign each infant to an adult
            $associatedAdultId = ($i % $adultsCount) + 1; // Distribute infants among adults
            $travelers[] = [
                'id' => $adultsCount + $childrenCount + $i,
                'travelerType' => 'HELD_INFANT',
                'age' => 1,
                'associatedAdultId' => $associatedAdultId
            ];
        }

        // Dynamically build the originDestinations array based on form data
        $originDestinations = [];
        foreach ($request->input('originLocationCodes') as $key => $origin) {
            $originDestinations[] = [
                'id' => $key + 1,
                'originLocationCode' => $origin,
                'destinationLocationCode' => $request->input('destinationLocationCodes')[$key],
                'departureDateTimeRange' => [
                    'date' => $request->input('departureDateRanges')[$key]
                ]
            ];
        }

        $data = [
            'originDestinations' => $originDestinations,
            'travelers' => $travelers,
            'currencyCode' => $request->currency,
            'sources' => ['GDS'],
            'sort' => 'price',
            'searchCriteria' => [
                'flightFilters' => [
                    'cabinRestrictions' => [
                        [
                            'cabin' => $request->cabin,
                            'coverage' => 'AT_LEAST_ONE_SEGMENT',
                            'originDestinationIds' => array_column($originDestinations, 'id'),
                        ],
                    ],
                ],
            ],
        ];

        //$airports = $this->airports();
        // Access the lazy-loaded airports list
        $airports = $this->getAirports();

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
            //$flights = $response->data;
            $flight_option = $request->flight_option;
            //return $flights;
            return view('amadeus.multicity', compact('flights', 'airports', 'flight_option'));
        } catch (GuzzleException $exception) {
            // Handle the exception or log it if needed
            return view('amadeus.multicity', compact('airports'))
                ->with(['exception' => $exception->getMessage()]);
        }
    }


    public function registermodal(Request $request)
    {
        if (!Auth::check()) {
            $request->validate([
                'surname' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            $user = new User;
            $user->surname = $request['surname'];
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->password = bcrypt($request['password']);
            $user->email_verified_at = now();
            $user->save();

            if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

                if (!Auth::attempt(['phone' => $request['phone'], 'password' => $request['password']])) {
                    return back()->withErrors('Failed to log in to the account created, please login to check your booking');
                }
            }
            return response()->json(['success' => 'Successfully registered ']);
        }
    }

    public function registermodal_x(Request $request)
    {
        // if (!Auth::check()) {
        //     $request->validate([
        //         'surname' => ['required', 'string', 'max:255'],
        //         'name' => ['required', 'string', 'max:255'],
        //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //         'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
        //         //'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
        //         //'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
        //         'password' => ['required', 'string', 'min:8', 'confirmed']
        //     ]);

        //     $user = new User;
        //     $user->surname = $request['surname'];
        //     $user->name = $request['name'];
        //     $user->email = $request['email'];
        //     $user->phone = $request['phone'];
        //     $user->password = bcrypt($request['password']);
        //     $user->email_verified_at = now();
        //     $user->save();

        //     // Attempt authentication after registration
        //     if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']]) ||
        //         Auth::attempt(['phone' => $validated['phone'], 'password' => $validated['password']])) {
        //         return response()->json(['success' => 'Successfully registered and logged in']);
        //     }

        //     return response()->json(['success' => 'Successfully registered ']);

        //     // Return JSON error response if authentication fails
        //     //return response()->json(['error' => 'Failed to log in to the account created, please login to check your booking'], 422);
        // }
    }


    //login modal
    public function loginmodal(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'email' => ['nullable', 'string', 'email', 'max:255', 'exists:users,email'],// , 'required_without:phone'
            'phone' => ['nullable', 'string', 'max:255', 'exists:users,phone', 'required_without:email'],
            'password' => ['required', 'string']
        ]);

        // Attempt authentication with email
        if (isset($validated['email']) && Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return response()->json(['success' => 'Successfully logged in with email']);
        }

        // Attempt authentication with phone
        if (isset($validated['phone']) && Auth::attempt(['phone' => $validated['phone'], 'password' => $validated['password']])) {
            return response()->json(['success' => 'Successfully logged in with phone']);
        }

        // If authentication fails
        return response()->json(['error' => 'Failed to log in with the provided credentials.'], 422);

    }



    public function airportName($iata)
    {
        $airport = Airport::where('iata', $iata)->first();

        if ($airport) {
            return $airport->name;
        }
        return null;
    }

    public function airlineName($code)
    {
        $airline = Airline::where('code', $code)->first();

        if ($airline) {
            return $airline->name;
        }
        return null;
    }

    public function carHire()
    {
        $vehicles = Vehicle::where('status', 'active')->paginate(6);
        return view('car_hire', compact('vehicles'));
    }

    public function busHire()
    {
        $locations = Busloc::distinct()->pluck('buslocation')->toArray();
        //$destinationCities = Route::distinct()->pluck('dest')->toArray();

        $buses = Bus::where('status', 'active')->paginate(6);
        return view('bus_hire', compact('buses', 'locations'));
    }
    public function shuttleHire()
    {
        $shuttles = Shuttle::where('status', 'active')->paginate(6);
        $airports = Airport::orderBy('id', 'desc')->pluck('name'); // pluck('buslocation')->toArray()
        return view('shuttle_hire', compact('shuttles', 'airports'));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $type = $request->type;
        $keyword = $request->keyword;
        if ($type == 'bus') {
            //check if therre is any vehicle
            $results = Bus::Where('city', 'LIKE', "%{$keyword}%")
                ->orWhere('country', 'LIKE', "%{$keyword}%")
                ->orWhere('transmission', 'LIKE', "%{$keyword}%")
                ->orWhere('fuel_type', 'LIKE', "%{$keyword}%")
                ->orWhere('address', 'LIKE', "%{$keyword}%")
                ->orWhere('make', 'LIKE', "%{$keyword}%")
                ->orWhere('model', 'LIKE', "%{$keyword}%")
                ->orWhere('seater', 'LIKE', "%{$keyword}%")
                ->orWhere('engine_size', 'LIKE', "%{$keyword}%")
                ->orWhere('price', 'LIKE', "%{$keyword}%")
                ->orWhere('year', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->where('status', 'active')
                ->paginate(12);
        } elseif ($type == 'shuttle') {
            //check if therre is any vehicle
            $results = Shuttle::Where('city', 'LIKE', "%{$keyword}%")
                ->orWhere('country', 'LIKE', "%{$keyword}%")
                ->orWhere('transmission', 'LIKE', "%{$keyword}%")
                ->orWhere('fuel_type', 'LIKE', "%{$keyword}%")
                ->orWhere('address', 'LIKE', "%{$keyword}%")
                ->orWhere('make', 'LIKE', "%{$keyword}%")
                ->orWhere('model', 'LIKE', "%{$keyword}%")
                ->orWhere('seater', 'LIKE', "%{$keyword}%")
                ->orWhere('engine_size', 'LIKE', "%{$keyword}%")
                ->orWhere('price', 'LIKE', "%{$keyword}%")
                ->orWhere('year', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->where('status', 'active')
                ->paginate(12);
        } elseif ($type == 'vehicle') {
            //check if therre is any vehicle
            // $results = Vehicle::Where('city', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('country', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('transmission', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('fuel_type', 'LIKE', "%{$keyword}%")
            //     ->orWhere('address', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('make', 'LIKE', "%{$keyword}%")
            //     ->orWhere('model', 'LIKE', "%{$keyword}%")
            //     ->orWhere('engine_size', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('price', 'LIKE', "%{$keyword}%")
            //     ->orWhere('year', 'LIKE', "%{$keyword}%")
            //     ->orWhere('name', 'LIKE', "%{$keyword}%")
            //     ->where('status', 'active')
            //     ->paginate(12);
            $results = Vehicle::where('status', 'active')
                ->where(function ($query) use ($keyword) {
                    $query->where('city', 'LIKE', "%{$keyword}%")
                        ->orWhere('country', 'LIKE', "%{$keyword}%")
                        ->orWhere('transmission', 'LIKE', "%{$keyword}%")
                        ->orWhere('fuel_type', 'LIKE', "%{$keyword}%")
                        ->orWhere('address', 'LIKE', "%{$keyword}%")
                        ->orWhere('make', 'LIKE', "%{$keyword}%")
                        ->orWhere('model', 'LIKE', "%{$keyword}%")
                        ->orWhere('engine_size', 'LIKE', "%{$keyword}%")
                        ->orWhere('price', 'LIKE', "%{$keyword}%")
                        ->orWhere('year', 'LIKE', "%{$keyword}%")
                        ->orWhere('name', 'LIKE', "%{$keyword}%");
                })->paginate(12);
        } elseif ($type == 'flight') {
            return view('flight');
        } else {
            //check if therre is any apartment
            // $results = Apartment::Where('city', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('address', 'LIKE', "%{$keyword}%")
            //     ->orWhere('country', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('price', 'LIKE', "%{$keyword}%")
            //     ->orWhere('name', 'LIKE', "%{$keyword}%")
            //     ->where('status', 'active')
            //     ->paginate(9);
            $results = Apartment::where('status', 'active')
                ->where(function ($query) use ($keyword) {
                    $query->where('city', 'LIKE', "%{$keyword}%")
                        ->orWhere('address', 'LIKE', "%{$keyword}%")
                        ->orWhere('country', 'LIKE', "%{$keyword}%")
                        ->orWhere('price', 'LIKE', "%{$keyword}%")
                        ->orWhere('name', 'LIKE', "%{$keyword}%");
                })->paginate(9);
        }

        return view('search', compact('results', 'type'));
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactUs(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:500',
            'g-recaptcha-response' => 'required'
        ]);

        // $recaptchaResponse = $request->input('g-recaptcha-response');
        // $recaptchaSecret = env('RECAPTCHA_SECRET');
        // $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

        // // Initialize cURL
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $recaptchaUrl);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        //     'secret' => $recaptchaSecret,
        //     'response' => $recaptchaResponse,
        //     'remoteip' => $request->ip(),
        // ]));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $response = curl_exec($ch);
        // curl_close($ch);

        // // Decode the JSON response
        // $responseData = json_decode($response);

        // // Check if reCAPTCHA was successful
        // if (!$responseData->success) {
        //     return redirect()->back()->withErrors(['captcha' => 'Captcha validation failed.']);
        // }

        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = 'your-secret-key';

        // Verify the reCAPTCHA response
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
        ]);

        $result = $response->json();

        if (!$result['success']) {
            return redirect()->back()->withErrors(['captcha' => 'Captcha verification failed.']);
        }

        // Save contact data
        $cont = new Contact;
        $cont->name = $request->input('name');
        $cont->email = $request->input('email');
        $cont->subject = $request->input('subject');
        $cont->message = $request->input('message');
        $cont->save();

        // Send notification
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new ContactUs($cont));

        // Flash success message to session
        return redirect()->back()->with('status', 'Hi ' . $request->input('name') . ', thank you for your comments. We will get back to you shortly.');
    }

    public function contactInfo()
    {
        $contacts = Contact::all();
        return view('contactinfo.index', compact('contacts'));
    }

    public function apartments()
    {
        $apartments = Apartment::where('status', 'active')->paginate(6);
        $cities = Apartment::where('status', 'active')->select('city as name')->distinct()->get();
        return view('apartments', compact('apartments', 'cities'));
    }

    public function singleApartment($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('single-apartment', compact('apartment'));
    }

    public function singleVehicle($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('single-vehicle', compact('vehicle'));
    }

    public function singleBus($id)
    {
        $bus = Bus::findOrFail($id);
        return view('single-bus', compact('bus'));
    }
    public function singleShuttle($id)
    {
        $shuttle = Shuttle::findOrFail($id);
        return view('single-shuttle', compact('shuttle'));
    }
    public function getLoginRoute()
    {
        $redirectPath = url()->previous();
        return view('auth.login_redirect', compact('redirectPath'));
    }

    public function postLoginRoute(Request $request)
    {
        if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            if (!Auth::attempt(['phone' => $request['phone'], 'password' => $request['password']])) {
                return back()->withErrors('Failed to log in to the account created');
            }
        }
        return redirect($request['redirectPath']);
    }
}
