<?php
// Tell PayFast that this page is reachable by triggering a header 200
header('HTTP/1.0 200 OK');
flush();

//require('../../../vendor/autoload.php');
//require __DIR__ . '/../../../vendor/autoload.php';

use PayFast\PayFastPayment;

$amount = '11.00';

try {
    $payfast = new PayFastPayment(
        [
            'merchantId' => '10028652',
            'merchantKey' => 'qgo0fllvzbcp8',
            'passPhrase' => 'ab1s1n1yaTravel',
            'testMode' => true

        ]
    );

    $notification = $payfast->notification->isValidNotification($_POST, ['amount_gross' => $amount]);
    //dd($notification);
    if ($notification === true) {
        // All checks have passed, the payment is successful
        // fwrite($myFile, "All checks valid\n");
        dd('All checks valid\n');
    } else {
        // Some checks have failed, check payment manually and log for investigation -> PayFastPayment::$errorMsg
        // fwrite($myFile, implode("\n",PayFastPayment::$errorMsg));
        dd('Some checks have failed, check payment manually and log for investigation ' . implode("\n", PayFastPayment::$errorMsg));
    }
} catch (Exception $e) {
    // Handle exception
    // fwrite($myFile, 'There was an exception: '.$e->getMessage());
    dd('There was an exception: ' . $e->getMessage());
}
