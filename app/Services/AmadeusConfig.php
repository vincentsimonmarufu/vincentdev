<?php

namespace App\Services;

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;

class AmadeusConfig
{
    protected $amadeus;

    public function __construct()
    {
        //$this->amadeus = Amadeus::builder()
          //  ->setClientId(env('AMADEUS_API_KEY'))
            //->setClientSecret(env('AMADEUS_API_SECRET'))
            //->build();
            // $this->amadeus = Amadeus::builder([
            //     'client_id' => env('AMADEUS_API_KEY'),
            //     'client_secret' => env('AMADEUS_API_SECRET')
            // ])->build();
        $apiKey =env('AMADEUS_API_KEY');
        $apiSecret = env('AMADEUS_API_SECRET');
        $this->amadeus = Amadeus::builder($apiKey, $apiSecret)
       // ->setProductionEnvironment()
        ->build();
    }

    public function getClient()
    {
        return $this->amadeus;
    }

    public function getAccessToken()
    {
        try {
            $accessToken = $this->amadeus->getAccessToken();
            return $accessToken;
        } catch (ResponseException $e) {
            throw new \Exception('Unable to fetch access token.');
        }
    }
}
