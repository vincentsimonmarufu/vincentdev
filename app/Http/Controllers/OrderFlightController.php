<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\FlightBooking;
use App\Models\Passenger;
use Illuminate\Support\Facades\Auth;
use App\Models\FlightBookingResponse;
use App\Services\AmadeusAccessTokenService;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\File;
use App\Models\Airport;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\App;
use App\Notifications\UserMail;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Airline;
use App\Models\Segment;
use Illuminate\Support\Str;

class OrderFlightController extends Controller
{
    protected $accessTokenService;
    protected $airports;

    // added service to this controller
    public function __construct(AmadeusAccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
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


    // getting seats details using flightorderid
    public function selectSeat_x(Request $request, Client $client)
    {
        //     //$flightOrderId = $request->input('flightOrderId'); //$request->flight_option;
        //     //$flightOrderId = $request->flightOrderId;
        //     $flightOrderId = $request->query('flightOrderId');
        //     //return $flightOrderId;


        //     if (!$flightOrderId) {
        //         return response()->json(['error' => 'Flight order id not found.'], 404);
        //     }

        //     $url = 'https://test.travel.api.amadeus.com/v1/shopping/seatmap';
        //     $access_token = $this->accessTokenService->getAccessToken($client);

        //     // Generate a random UUID
        //     //$amaClientRef = Uuid::uuid4()->toString();
        //     $amaClientRef = Carbon::now()->toIso8601ZuluString('microsecond');
        //     try {
        //         $response = Http::withHeaders([
        //             'Authorization' => 'Bearer ' . $access_token,
        //             'Accept' => 'application/json',
        //             'ama-client-ref' => $amaClientRef,
        //         ])->get($url, [
        //             'flightOrderId' => $flightOrderId,
        //         ]); //json data from array

        //         //return 'seat_map';

        //         if ($response->successful()) {
        //             $data = $response->json(); //Converts JSON to PHP array
        //             return response()->json($data); //converts from php to json back
        //         } else {
        //             return response()->json([
        //                 'error' => 'Failed to retrieve seat map information',
        //                 'details' => $response->json()
        //             ], $response->status());
        //         }
        //     }catch (RequestException $e) {
        //         if ($e->hasResponse()) {
        //             $amaRequestId = $e->getResponse()->getHeader('Ama-Request-Id')[0] ?? 'Not available';
        //             $amaClientRef = $e->getResponse()->getHeader('Ama-Client-Ref')[0] ?? 'Not available';
        //             $errorResponse = $e->getResponse()->getBody()->getContents();

        //             Log::error('Ama-Request-Id: ' . $amaRequestId);
        //             Log::error('Ama-Client-Ref: ' . $amaClientRef);
        //             Log::error('Request Error: ' . $errorResponse);
        //             echo 'Request Error: ' . $errorResponse;
        //         } else {
        //             Log::error('Request Error: ' . $e->getMessage());
        //             echo 'Request Error: ' . $e->getMessage();
        //            // return view('amadeus.search', compact('airports'))
        //             //->with(['exception' => $e->getMessage()]);
        //         }
        //     }

    }


    public function __invoke(Request $request, Client $client)
    {
        //return $request->all();
        //$url = 'https://test.api.amadeus.com/v1/booking/flight-orders';
        $url = 'https://test.travel.api.amadeus.com/v1/booking/flight-orders';
        $access_token = $this->accessTokenService->getAccessToken($client);
        $flightoffer = json_decode($request['data'])->flightOffers[0];
        //return $flightoffer;
        // passengers data
        $passengers = [];
        foreach ($request->input('passengers') as $passengerData) {

            $countryCallingCode = trim($passengerData['contact']['phones'][0]['countryCallingCode'], '+');
            $passenger = [
                'id' => $passengerData['id'],
                'dateOfBirth' => $passengerData['dob'],
                'name' => [
                    'firstName' => $passengerData['name']['firstName'],
                    'lastName' => $passengerData['name']['lastName'],
                ],
                'gender' => $passengerData['gender'],
                'contact' => [
                    'emailAddress' => $passengerData['contact']['emailAddress'],
                    'phones' => [
                        [
                            'deviceType' => 'MOBILE',
                            'countryCallingCode' => $countryCallingCode,
                            'number' => $passengerData['contact']['phones'][0]['number'],
                        ],
                    ],
                ],
                'documents' => [
                    [
                        'documentType' => 'PASSPORT',
                        'birthPlace' => 'Harare',
                        'issuanceLocation' => 'Harare',
                        'issuanceDate' => '2000-07-17',
                        'number' => '00000000',
                        'expiryDate' => '2025-07-17',
                        'issuanceCountry' => 'ZW',
                        'validityCountry' => 'ZW',
                        'nationality' => 'ZW',
                        'holder' => true
                    ]
                ]
            ];
            $passengers[] = $passenger;
        }

        //return $passengers;

        //return $passengers;
        $data = [
            'data' => [
                'type' => 'flight-order',
                'flightOffers' => [
                    json_decode($request['data'])->flightOffers[0]
                ],
                'travelers' => $passengers
            ]
        ];

        // return $data;
        // Generate a random UUID
        //$amaClientRef = Uuid::uuid4()->toString();
        $amaClientRef = Carbon::now()->toIso8601ZuluString('microsecond');
        $airports = $this->getAirports();
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token,
                    'ama-client-ref' => $amaClientRef,
                ],
                'json' => $data
            ]);

            $response = $response->getBody();
            $response = json_decode($response);
            $flight = $response->data;
            //return $flight;
            $segments = $flight->flightOffers[0]->itineraries[0]->segments;
            Log::info('segments');
            Log::info($segments);

            $departureFrom = $segments[0]->departure->iataCode;
            $departureAirport = $this->airportName($departureFrom);
            Log::info('departure code : ' . $departureFrom . '----->' . $departureAirport);

            $arrivalTo = end($segments)->arrival->iataCode;
            $arrivalAirport = $this->airportName($arrivalTo);
            Log::info('arrival: ' . $arrivalTo . '-------->' . $departureAirport);

            //return $arrivalTo;
            //return $departureAirport.'<=================>'.$arrivalAirport;

            //return $segments;

            // Extract the first segment's departure and the last segment's arrival
            //$firstSegment = $segments[0];
            //$lastSegment = end($segments);

            //dd($firstSegment);
            // segments


            // persist flight_bookings
            $flightbooking = new FlightBooking;
            $flightbooking->flight_id = $flight->id;
            $flightbooking->reference = $flight->associatedRecords[0]->reference;
            $flightbooking->queuingOfficeId = 'JNBZA2195'; // $flight->queuingOfficeId
            $flightbooking->price = $request->price;
            $flightbooking->currency = $request->currency;
            //$flightbooking->departure = $request->departure;
            //$flightbooking->arrival = $request->arrival;
            $flightbooking->departure = $departureAirport; //airlineName($code)
            $flightbooking->arrival = $arrivalAirport; //$request->arrival
            $flightbooking->airline = $request->airline;
            $flightbooking->carrierCode = $flight->flightOffers[0]->itineraries[0]->segments[0]->carrierCode;
            $flightbooking->travel_class = $flight->flightOffers[0]->travelerPricings[0]->fareDetailsBySegment[0]->cabin;
            $flightbooking->flight_option = $request->flight_option;
            $flightbooking->status = 'pending'; //$flight->ticketingAgreement->option
            $flightbooking->user_id = Auth::user()->id;
            $flightbooking->save();

            // persist segments
            foreach ($segments as $segment) {
                //Log::info('segment');
                //Log::info($segment);
                //Log::info('<--------->');
                $segm = new Segment;
                //$segment->id = $flight->id;
                $segm->flight_booking_id = trim($flightbooking->id);
                $segm->departure_iata = $segment->departure->iataCode;
                $segm->arrival_iata = $segment->arrival->iataCode;
                $segm->departure_terminal = $segment->departure->terminal ?? '';
                $segm->arrival_terminal = $segment->arrival->terminal ?? '';
                $segm->departure_date_time = $segment->departure->at;
                $segm->arrival_date_time = $segment->arrival->at;
                $segm->carrier_code = $segment->carrierCode;
                $segm->flight_number = $segment->number;
                $segm->aircraft_number = $segment->aircraft->code;
                $segm->number_of_stops = $segment->numberOfStops;
                $segm->duration = $segment->duration;

                $segm->save();
            }


            // Capture dynamically created fields
            foreach ($request->input('passengers') as $index => $passengerData) {
                $passenger = new Passenger;
                $passenger->flight_booking_id = $flightbooking->id;
                $passenger->name = $passengerData['name']['firstName'];
                $passenger->surname = $passengerData['name']['lastName'];
                $passenger->dob = $passengerData['dob'];
                $passenger->gender = $passengerData['gender'];
                $passenger->email = $passengerData['contact']['emailAddress'];
                $passenger->code = $passengerData['contact']['phones'][0]['countryCallingCode'];
                $passenger->phone = $passengerData['contact']['phones'][0]['number'];

                // Handle file upload for passport
                // if ($request->hasFile("passengers.{$index}.passport")) {
                //     $image = $request->file("passengers.{$index}.passport");
                //     $imageName = 'passport_' . time() . '.' . $image->getClientOriginalExtension();
                //     $image->storeAs('public/passports', $imageName);
                //     $passenger->file_path = $imageName;
                // }
                $passenger->file_path = '';
                $passenger->passport = '';
                $passenger->save();
            }

            //send notification
            $msg = 'New flight booking, to view the flight request please click on the button below.';
            $link = route('view.flights', $flightbooking->reference);
            $details = [
                'subject' => 'New flight Booking',
                'message' => $msg,
                'actionURL' => $link
            ];

            /*
               Notification::send(Auth::user(), new UserMail($details));//send owner of the booking
               $users = User::where('role', 'admin')->get();
               Notification::send($users, new UserMail($details));
               //send sms
               $parameters = ['New flight booking :  '.$flightbooking->reference];
               $controller = App::make('\App\Http\Controllers\NotificationsController');
               $data = $controller->callAction('sms',$parameters);
            */


            return view('payfast', compact('flightbooking')); //payfast.payPayfast // to show payment detail
            //return redirect()->route('payfast.flightPayfast', ['flightbooking' => $flightbooking]);

            // Redirect to Payfast payment page with flight details
            //return redirect()->route('payment.form', ['flightbooking' => $flightbooking]); // working

            //return view('amadeus.confirm', compact('flight'));// for testing
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
            // Log::error('Request Error with : ' . $errorData);
            Log::error('Request Error with : ' . json_encode($errorData));

            // Provide user-friendly message based on error code
            $userMessage = 'An unexpected error occurred. Please try again later.';
            if (isset($errorData['errors']) && is_array($errorData['errors'])) {
                foreach ($errorData['errors'] as $error) {
                    switch ($error['code']) {
                        case 34651: // Segment sell failure
                            $userMessage = 'Could not sell the flight segment. Please check the flight details and try again.';
                            break;
                        // Add more cases as needed
                        default:
                            $userMessage = 'An unexpected error occurred. Please try again later.';
                            break;
                    }
                }
            }

            // Store the message in the session
            session()->flash('userMessage', $userMessage);

            // Return error view with user-friendly message
            //return view('error', ['message' => $userMessage]);
            //return view('amadeus.search', compact('airports'));
            // Redirect to a route or URL
            return redirect()->route('flights.searching');
            //->with(['message' => $userMessage]);
            //echo $userMessage;
        }

    }


    // ticketissuance
    public function ticketissuance($pnrId, Client $client)
    {
        // Replace the URL-safe characters back to original Base64 characters
        $pnrId = Str::replace(['-', '_'], ['+', '/'], $pnrId);
        // Decode the Base64 string (without padding)
        $decodePnrId = base64_decode($pnrId);

        // Use the decoded order ID directly in the URL
        $url = 'https://test.travel.api.amadeus.com/v1/booking/ticket';
        $access_token = $this->accessTokenService->getAccessToken($client);
        $amaClientRef = Carbon::now()->toIso8601ZuluString('microsecond');

        // $data = [
        //     'formOfPayments' => [
        //         [
        //             'other' => [
        //                 'method' => 'CASH'
        //             ]
        //         ]
        //     ]
        // ];

        try {
            $response = $client->get($url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $access_token,
                    'ama-client-ref' => $amaClientRef,
                ],
                'query' => [
                    'ticketNumber' => $decodePnrId,
                ],
            ]);

            $ticketData = json_decode($response->getBody(), true);
            echo $ticketData;
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
            // Log::error('Request Error with : ' . $errorData);
            Log::error('Request Error with : ' . json_encode($errorData));

            // Provide user-friendly message based on error code
            //$userMessage = 'An unexpected error occurred. Please try again later.';
            //    if (isset($errorData['errors']) && is_array($errorData['errors'])) {
            //        foreach ($errorData['errors'] as $error) {
            //            switch ($error['code']) {
            //                case 38196: // Segment sell failure
            //                    $userMessage = 'Could not sell the flight segment. Please check the flight details and try again.';
            //                    break;
            //                // Add more cases as needed
            //                default:
            //                    $userMessage = 'An unexpected error occurred. Please try again later.';
            //                    break;
            //            }
            //        }
            //    }
        }

    }


    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $flightRequests = FlightBooking::orderBy('id', 'Desc')->with('user')->get();
        } else {
            $flightRequests = FlightBooking::orderBy('id', 'Desc')->where('user_id', Auth::user()->id)->get();
        }
        return view('amadeus.myflights', compact('flightRequests'));
    }


    // flight detail using flight_booking_id
    //  public function show($ref){

    //         $flightRequest = FlightBooking::where('id', $flight_booking_id)
    //         ->first();
    //         //return $flightRequest;

    //         // $passengers = Passenger::where('id', $flightRequest->id)
    //         // ->get();
    //         $passengers = Passenger::where('flight_booking_id', $flight_booking_id)->get();

    //         $responses = FlightBookingResponse::where('flight_booking_id', $flightRequest->id)->orderBy('created_at','Desc')->get();

    //         return view('amadeus.viewbooking', compact('flightRequest', 'passengers','responses'));
    //  }

    // 29/09/2024
    public function show($ref)
    {
        //return $ref;
        // $flightRequest = FlightBooking::where('reference',$ref)
        // ->first();
        //$reference = $ref;
        // Retrieve the flight booking by it's reference
        //$flightRequest = FlightBooking::with('segments')->findOrFail($reference); //getting not found due to access not by primary key

        //$flightRequest = FlightBooking::with('segments')->where('reference', $ref)->first(); // working
        $flightRequest = FlightBooking::where('reference', $ref)->first();
        //return $flightRequest;

        // Now accessing the segments
        $segments = $flightRequest->segments;

        //return $flightRequest;

        // $passengers = Passenger::where('id',$flightRequest->id)
        // ->get();
        $passengers = Passenger::where('flight_booking_id', $flightRequest->id)->get();

        $responses = FlightBookingResponse::where('flight_booking_id', $flightRequest->id)->orderBy('created_at', 'Desc')->get();


        // return ['flightRequest'=> $flightRequest, 'passengers' => $passengers, 'responses' => $responses];

        return view('amadeus.viewbooking', compact('flightRequest', 'passengers', 'responses', 'segments'));
    }


    // 24/092024
    // public function show($ref){

    //     $flightRequest = FlightBooking::where('reference',$ref)
    //     ->first();

    //     //return $flightRequest;

    //     // $passengers = Passenger::where('id',$flightRequest->id)
    //     // ->get();
    //     $passengers = Passenger::where('flight_booking_id', $flightRequest->id)->get();
    //     $responses = FlightBookingResponse::where('flight_booking_id',  $flightRequest->id)->orderBy('created_at','Desc')->get();


    //    // return ['flightRequest'=> $flightRequest, 'passengers' => $passengers, 'responses' => $responses];

    //     return view('amadeus.viewbooking', compact('flightRequest', 'passengers','responses'));
    // }


    public function destroy($id)
    {
        $flightRequest = FlightBooking::findOrFail($id);
        $flightRequest->delete();
        return back()->with('status', 'Successfully deleted flight booking');
    }

    public function airlineName($code)
    {
        $airline = Airline::where('code', $code)->first();

        if ($airline) {
            return $airline->name;
        }
        return null;
    }

    public function airportName($iata)
    {
        $airport = Airport::where('iata', $iata)->first();

        if ($airport) {
            return $airport->name;
        }
        return null;
    }


}
