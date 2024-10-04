<?php

namespace App\Traits;

trait MessageTrait
{
    protected function sendSMS($destinations, $message)
    {
        $username = 'Abisiniya';
        $token = '95cb44fe3321e0f2299f62051e87c5c6';
        $bulksms_ws = 'http://portal.bulksmsweb.com/index.php?app=ws';
        $ws_str = $bulksms_ws . '&u=' . $username . '&h=' . $token . '&op=pv';
        $ws_str .= '&to=' . urlencode($destinations) . '&msg='.urlencode($message);
        $ws_response = @file_get_contents($ws_str);

/*
$url ='https://api.bulksms.com/v1';
$token = 'B84011B5C0CE416BA6F090A2C1C0E526-02-F';
$t_secret ='ZbnehAJkyrVHW6TaMdSL6VVgux7__';
$basic_auth ='Authorization: Basic Qjg0MDExQjVDMENFNDE2QkE2RjA5MEEyQzFDMEU1MjYtMDItRjpaYm5laEFKa3lyVkhXNlRhTWRTTDZWVmd1eDdfXw==';
{
    "from": "+27007654321",
    "to": "+27001234567",
    "body": "Hello World!"
}
{
    "to": ["+27001234567", "+27002345678", "+27003456789"],
    "body": "Happy Holidays!"
}
*/

    }
}

?>