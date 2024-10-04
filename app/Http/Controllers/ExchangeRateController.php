<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ExchangeRateController extends Controller
{
    public static function getExchangeRate()
    {
        $apiKey = '46c9dd3ae6ac4987810ead4ee30b2a45'; // Replace with your ExchangeRate-API key
        $base = 'USD';
        $symbols = 'GBP,ZAR,EUR';
        $client = new Client();
       // https://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.$access_key.''
        $response = $client->get("http://api.exchangeratesapi.io/v1/latest?access_key={$apiKey}");

        $data = json_decode($response->getBody(), true);

        if (isset($data['rates']['ZAR'])) {
            $usdToZarRate = $data['rates']['ZAR'];
            //return response()->json(['usd_to_zar' => $usdToZarRate]);
            return  $usdToZarRate;
        } else {
            return response()->json(['error' => 'Failed to retrieve exchange rate.']);
        }
    }
}

