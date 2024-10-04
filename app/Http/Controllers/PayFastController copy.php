<?php

namespace App\Http\Controllers;

use App\Models\ITN;
use App\Models\Invoices;
use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\ExchangeRateTrait;
use Exception;

//require __DIR__ . '/../../../vendor/autoload.php';

use PayFast\PayFastPayment;

class PayFastController extends Controller
{
    use ExchangeRateTrait;

    public function payPayfast(Request $request)
    {
        // Construct variables
        $siteurl = url('/');
        //save payment then curl
        // If in testing mode make use of either sandbox.payfast.co.za or www.payfast.co.za
        //$testingMode = false;
        $testingMode = true;
        $pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
        $url = "https://'.$pfHost.'/eng/process";

        //  $invoice = Invoice::find($request->id);
        $amount = 10;  //$invoice->amount;
        $response = Http::asForm()->post(
            $url,
            [
                // Merchant details
                'receiver' => '10028652',
                'cmd' => '_paynow',
                // Requires HTTPS
                'return_url' => $siteurl . '/return-payment',
                // Requires HTTPS
                'cancel_url' => $siteurl . '/cancel-payment',
                // Requires HTTPS
                'notify_url' => 'https://www.abisiniya.com/notify-payment',

                // Buyer details
                'name_first' => 'First Name',
                'name_last' => 'Last Name',
                'email_address' => 'test@test.com',

                // Transaction details
                'm_payment_id' => '1234',
                //Unique payment ID to pass through to notify_url
                'amount' => $amount,
                'item_name' => 'Order#123',
                'item_description' => 'abisiniya'
            ]
        );
        //->json();
        /* if (isset($response['message'])) {
            // dd($response['message']);
            return redirect()->back()
                ->withErrors('There was one or more failures : ' . $response['message']);
        } else {

            $preview_url = $response['preview_url'];
            return view('content.viewppt', compact('content', 'preview_url'));
        }*/
    }
    public function create()
    {
        return back()->withErrors('i dont know');
    }
    public function cancel()
    {
        //return view('payments.cancel')->withErrors('Payment cancelled, No records changed');
        return view('payments.cancel')->with('Payment cancelled, No records changed');
    }
    public function return()
    {
        // return view('payments.return')->withErrors('status', 'Return payment ');
        return view('payments.return')->with('status', 'Return payment ');
    }
    public function notify(Request $request)
    {
        $name = "/logs/payfast-" . date("Y-m-d") . ".log";
        $myLogInfo = '<< ------------------------------ start payfast log ---------------------------------------------------- >>';
        file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);

        $invoice_id = $request->m_payment_id; //used as invoice id when posting payload to payfast
        $invoice = Invoices::find($invoice_id);
        if ($invoice == null) {
            $myLogInfo = 'Invoice not found' . implode("\n", $request->all());
            file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
            $amount = 0.00; //default the amount
        } else {
            $amount = $invoice->amount; //db invoice amount for cross reference
        }

        // Tell PayFast that this page is reachable by triggering a header 200
        header('HTTP/1.0 200 OK');
        flush();
        try {

            $payfast = new PayFastPayment(
                [
                    'merchantId' => '21817361',
                    'merchantKey' => 'hhyppbaiksrto',
                    //'passPhrase' => 'ab1s1n1yaTravel',
                    //'testMode' => false
                    //'merchantId' => '10028652',
                    // 'merchantKey' => 'qgo0fllvzbcp8',
                    'passPhrase' => 'ab1s1n1yaTravel',
                    'testMode' => false
                ]
            );


            $notification = $payfast->notification->isValidNotification($request->all(), ['amount_gross' => $amount]);
            if ($notification === true) {
                // All checks have passed, the payment is successful
                $myLogInfo = 'All checks valid \n the payment is successful' . implode("\n", $request->all());
                file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
                if ($invoice == null) {
                    $myLogInfo = 'Invoice not found' . implode("\n", $request->all());
                    file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
                } else {
                    $invoice->status = "paid"; //update invoice
                    $invoice->save();
                }
            } else {
                // Some checks have failed, check payment manually and log for investigation -> PayFastPayment::$errorMsg
                // fwrite($myFile, implode("\n",PayFastPayment::$errorMsg));
                $myLogInfo = 'Some checks have failed, check payment manually and log for investigation -> ' . implode("\n", PayFastPayment::$errorMsg) . ' \n request: ' . implode("\n", $request->all());
                file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
                if ($invoice == null) {
                    $myLogInfo = 'Invoice not found' . implode("\n", $request->all());
                    file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
                } else {
                    $invoice->status = "paid"; //update invoice
                    $invoice->save();
                }
            }
        } catch (Exception $e) {
            // Handle exception
            // fwrite($myFile, 'There was an exception: '.$e->getMessage());
            $myLogInfo = 'There was an exception: ' . $e->getMessage() . ' \n request: ' . implode("\n", $request->all());
            file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
        $myLogInfo = '<< ------------------------------ saving to db---------------------------------------------------- >>';
        file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);

        //save ITN to DB   
        $itn = new ITN;
        $itn->m_payment_id = $request->m_payment_id;
        $itn->pf_payment_id = $request->pf_payment_id;
        $itn->status = $request->payment_status;
        $itn->item = $request->item_name;
        $itn->description = $request->item_description;
        $itn->amount = $request->amount_gross;
        $itn->fee = $request->amount_fee;
        $itn->net = $request->amount_net;
        $itn->name = $request->name_first;
        $itn->surname = $request->name_last;
        $itn->email = $request->email_address;
        $itn->merchant_id = $request->merchant_id;
        $itn->signature = $request->signature;
        $itn->for = "abisiniya";
        $itn->save();
        echo "payfast notify ";

        $myLogInfo = '<< ------------------------------ end payfast log ---------------------------------------------------- >>';
        file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    public function notifybooking(Request $request)
    {
        $name = "/logs/payfast-" . date("Y-m-d") . ".log";
        $myLogInfo = '<< ------------------------------ start payfast log ---------------------------------------------------- >>';
        file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);

        $invoice_id = $request->m_payment_id; //used as invoice id when posting payload to payfast
        $booking = Booking::where('reference', $invoice_id);
        $invoice = Bookable::where('booking_id', $booking->id);
        if ($invoice == null) {
            $myLogInfo = 'Booking not found' . implode("\n", $request->all());
            file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
            $amount = 0.00; //default the amount
        } else {
            $exchangerate = $this->getExchangeRate();
            $amount = $invoice->price * $exchangerate; //db invoice amount for cross reference
        }

        // Tell PayFast that this page is reachable by triggering a header 200
        header('HTTP/1.0 200 OK');
        flush();
        try {

            $payfast = new PayFastPayment(
                [
                    'merchantId' => '21817361',
                    'merchantKey' => 'hhyppbaiksrto',
                    //'passPhrase' => 'ab1s1n1yaTravel',
                    //'testMode' => false
                    //'merchantId' => '10028652',
                    // 'merchantKey' => 'qgo0fllvzbcp8',
                    'passPhrase' => 'ab1s1n1yaTravel',
                    'testMode' => false
                ]
            );


            $notification = $payfast->notification->isValidNotification($request->all(), ['amount_gross' => $amount]);
            if ($notification === true) {
                // All checks have passed, the payment is successful
                $myLogInfo = 'All checks valid \n the payment is successful' . implode("\n", $request->all());
                file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
                if ($booking == null) {
                    $myLogInfo = 'Invoice not found' . implode("\n", $request->all());
                    file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
                } else {
                    $booking->status = "paid"; //update invoice
                    $booking->save();
                }
            } else {
                // Some checks have failed, check payment manually and log for investigation -> PayFastPayment::$errorMsg
                // fwrite($myFile, implode("\n",PayFastPayment::$errorMsg));
                $myLogInfo = 'Some checks have failed, check payment manually and log for investigation -> ' . implode("\n", PayFastPayment::$errorMsg) . ' \n request: ' . implode("\n", $request->all());
                file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
                if ($booking == null) {
                    $myLogInfo = 'Invoice not found' . implode("\n", $request->all());
                    file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
                } else {
                    $booking->status = "paid"; //update invoice
                    $invoice->save();
                }
            }
        } catch (Exception $e) {
            // Handle exception
            // fwrite($myFile, 'There was an exception: '.$e->getMessage());
            $myLogInfo = 'There was an exception: ' . $e->getMessage() . ' \n request: ' . implode("\n", $request->all());
            file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
        $myLogInfo = '<< ------------------------------ saving to db---------------------------------------------------- >>';
        file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);

        //save ITN to DB   
        $itn = new ITN;
        $itn->m_payment_id = $request->m_payment_id;
        $itn->pf_payment_id = $request->pf_payment_id;
        $itn->status = $request->payment_status;
        $itn->item = $request->item_name;
        $itn->description = $request->item_description;
        $itn->amount = $request->amount_gross;
        $itn->fee = $request->amount_fee;
        $itn->net = $request->amount_net;
        $itn->name = $request->name_first;
        $itn->surname = $request->name_last;
        $itn->email = $request->email_address;
        $itn->merchant_id = $request->merchant_id;
        $itn->signature = $request->signature;
        $itn->for = "abisiniya";
        $itn->save();
        echo "payfast notify ";

        $myLogInfo = '<< ------------------------------ end payfast log ---------------------------------------------------- >>';
        file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    public function success()
    {
        return view('payments.notify')->with('status', 'Successfully updated your payment status');
    }

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
