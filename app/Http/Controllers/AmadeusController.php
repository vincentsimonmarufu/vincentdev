<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;
use App\Services\AmadeusAccessTokenService;


class AmadeusController extends Controller
{

    protected $accessTokenService;

    // added service to this controller
    public function __construct(AmadeusAccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
    }

    public function getToken_xx()
    {
        $apiKey = '1qRiLn2yz5egTfEFiOLIPKnmOBLYE1wf';
        $apiSecret = 'gX6is2r1kEDC86VB';
        $client = new \GuzzleHttp\Client();
    
        $response = $client->request('POST', 'https://test.api.amadeus.com/v1/security/oauth2/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [  // Use 'form_params' instead of 'body'
                'grant_type' => 'client_credentials',
                'client_id' => $apiKey,
                'client_secret' => $apiSecret,
            ],
        ]);
    
        $data = json_decode($response->getBody(), true);
    
        // Check if 'access_token' key is present
        if (isset($data['access_token'])) {
            $accessToken = $data['access_token'];
            return $accessToken;
        } else {
            // Handle the case where access_token is not present
            //'Access token not obtained'
            return  null;
        }
    }
    
    public function searchFlights_xx()
    {
        $apiKey ='1qRiLn2yz5egTfEFiOLIPKnmOBLYE1wf';
        $apiSecret = 'gX6is2r1kEDC86VB';
       // $token = $this->getToken();
        $token ='SKRYiJTGe535g46fyvqNAT8LYXvD';
        $client = new \GuzzleHttp\Client();
    
        $response = $client->request('GET', 'https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=SYD&destinationLocationCode=BKK&departureDate=2023-12-11&adults=1&max=20', [
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

    public function amadeusToken_xx(){
        $apiKey ='1qRiLn2yz5egTfEFiOLIPKnmOBLYE1wf';
        $apiSecret = 'gX6is2r1kEDC86VB';
        $amadeus = Amadeus::builder($apiKey, $apiSecret)
       // ->setProductionEnvironment()
        ->build();
        return $amadeus;
    }


    public function amadeusToken(){
        $apiKey = env('AMADEUS_CLIENT_ID');
        $apiSecret = env('AMADEUS_CLIENT_SECRET');
        $amadeus = Amadeus::builder($apiKey, $apiSecret)
       // ->setProductionEnvironment()
        ->build();
        return $amadeus;
    }


    public function index_x()
    {
        $amadeus = $this->amadeusToken();

        // Flight Offers Search GET
        try {
            $flightOffers = $amadeus->getShopping()->getFlightOffers()->get([
                "originLocationCode" => "HRE",
                "destinationLocationCode" => "JNB",
                "departureDate" => "2023-12-29",
                "returnDate" => "2023-12-31",
                "adults" => 1,
                "currencyCode" => "USD"
            ]);
        } catch (\Amadeus\Client\ResultException $e) {
            // Check if it's a rate limit exceeded error
            if ($e->getStatusCode() == 429) {
                // Implement retry logic here, e.g., wait for a while and then retry the request
                sleep(60); // Sleep for 60 seconds (adjust as needed)
                $flightOffers = $amadeus->getShopping()->getFlightOffers()->get([
                    "originLocationCode" => "HRE",
                    "destinationLocationCode" => "JNB",
                    "departureDate" => "2023-12-29",
                    "returnDate" => "2023-12-31",
                    "adults" => 1,
                    "currencyCode" => "USD"
                ]);
            } else {
                // Handle other exceptions
                throw $e;
            }
        }

        // Get airline data
        $airlineCodes = [];
        foreach ($flightOffers as $flightOffer) {
          // $airlineCodes[] = $flightOffer->getValidatingAirlineCodes()[0];
        }

        $airlines = $this->getAirlinesData($amadeus, $airlineCodes);

        return view('flightapi.amadeus', ['flightOffers' => $flightOffers, 'airlines' => $airlines]);
        
    }
    
    public function roundtrip_x()
    {
        $amadeus = $this->amadeusToken();

        // Flight Offers Search GET
        try {
            $flightOffers = $amadeus->getShopping()->getFlightOffers()->get([
                "originLocationCode" => "HRE",
                "destinationLocationCode" => "JNB",
                "departureDate" => "2023-12-29",
                "returnDate" => "2023-12-31",
                "adults" => 1,
                "currencyCode" => "USD"
            ]);
        } catch (\Amadeus\Client\ResultException $e) {
            // Check if it's a rate limit exceeded error
            if ($e->getStatusCode() == 429) {
                // Implement retry logic here, e.g., wait for a while and then retry the request
                sleep(60); // Sleep for 60 seconds (adjust as needed)
                $flightOffers = $amadeus->getShopping()->getFlightOffers()->get([
                    "originLocationCode" => "HRE",
                    "destinationLocationCode" => "JNB",
                    "departureDate" => "2023-12-29",
                    "returnDate" => "2023-12-31",
                    "adults" => 1,
                    "currencyCode" => "USD"
                ]);
            } else {
                // Handle other exceptions
                throw $e;
            }
        }

        // Get airline data
        $airlineCodes = [];
        foreach ($flightOffers as $flightOffer) {
            $airlineCodes[] = $flightOffer->getValidatingAirlineCodes()[0];
        }

        $airlines = $this->getAirlinesData($amadeus, $airlineCodes);

        return view('flightapi.amadeus', ['flightOffers' => $flightOffers, 'airlines' => $airlines]);
    }
    public function multiCitySearch_x()
    {
        // Initialize Amadeus client
        $amadeus = $this->amadeusToken();

        // Multi-city Flight Offers Search GET
        $flightOffers = $amadeus->getShopping()->getFlightOffers()->get([
            [
                "originLocationCode"      => "HRE", // Departure airport code for the first leg
                "destinationLocationCode" => "JNB", // Arrival airport code for the first leg
                "departureDate"           => "2023-12-29", // Departure date for the first leg
                // ... other parameters for the first leg
            ],
            [
                "originLocationCode"      => "JNB", // Departure airport code for the second leg
                "destinationLocationCode" => "LHR", // Arrival airport code for the second leg
                "departureDate"           => "2023-12-31", // Departure date for the second leg
                // ... other parameters for the second leg
            ],
            // ... add more legs as needed
        ]);

        return view('flightapi.amadeus', ['flightOffers' => $flightOffers]);
    }


    private function getAirlinesData($amadeus, $airlineCodes)
    {
        $airlinesData = [];
    
        foreach ($airlineCodes as $code) {
            $name = $amadeus->getReferenceData()->getAirlines()->get(["airlineCodes" => $code]);
            $airlinesData[$code] = $name[0]->getBusinessName();
        }
    
        return $airlinesData;
    }

    
    public function getName($airlineCode)
    {
        $amadeus = $this->amadeusToken();
        $airlinesData = [];
            $name = $amadeus->getReferenceData()->getAirlines()->get(["airlineCodes" => $airlineCode]);
            $airlinesData = $name[0]->getBusinessName();
        
    
        return $airlinesData;
    }
    
    
}
