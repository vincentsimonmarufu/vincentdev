<?php  
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AmadeusAccessTokenService
{
    
    // create access token   
    public function getAccessToken(Client $client)
    {         
        $clientId = env('AMADEUS_CLIENT_ID');
        $clientSecret = env('AMADEUS_CLIENT_SECRET');       
       
        $url = 'https://test.travel.api.amadeus.com/v1/security/oauth2/token';
        
        try {
            $response = $client->post($url, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret 
                ],
            ]);

            $accessToken = json_decode($response->getBody())->access_token;

            return $accessToken;           
        } catch (GuzzleException $exception) {           
            error_log('Error retrieving access token: ' . $exception->getMessage());
            return null; 
        }
    }
}
