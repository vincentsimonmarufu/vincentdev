<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlightBooking;
use Illuminate\Support\Facades\Http;
use PayFast\PayFastPayment;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment.initiate');
    }

    public function initiatePayment(Request $request)
    {
        $testingMode = true;
        $pfHost = $testingMode ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
        $url = "https://$pfHost/eng/process";

        $amount = 10; // Replace this with the actual amount

        $response = Http::asForm()->post($url, [
            'merchant_id' => '10034395',
            'merchant_key' => 's6qs4319o0vzi',
            'return_url' => route('payment.return'),
            'cancel_url' => route('payment.cancel'),
            'notify_url' => route('payment.notify'),
            // Buyer details
            'name_first' => 'First Name',
            'name_last' => 'Last Name',
            'email_address' => 'test@test.com',
            // Transaction details
            'm_payment_id' => '1234', // Unique payment ID to pass through to notify_url
            'amount' => $amount,
            'item_name' => 'Order#123',
            'item_description' => 'abisiniya'
        ]);

        if ($response->failed()) {
            return redirect()->back()->withErrors('There was one or more failures: ' . $response->body());
        } else {
            $responseBody = $response->json();
            if (isset($responseBody['redirect_url'])) {
                return redirect($responseBody['redirect_url']);
            }
            // Handle other response scenarios as needed
           // $this->handlePaymentNotification($responseBody);
           $this->notify($request);
        }
    }

    public function success()
    {
        // Handle the success logic
        return view('payment.success');
    }

    public function cancel()
    {
        // Handle the cancellation logic
        return view('payment.cancel');
    }

    public function notify(Request $request)
    {
        $name = "/logs/payfast-" . date("Y-m-d") . ".log";
        $myLogInfo = '<< ------------------------------ start payfast log ---------------------------------------------------- >>';
       // file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);

        // $invoice_id = $request->m_payment_id; //used as invoice id when posting payload to payfast
        // $invoice = Invoices::find($invoice_id);
        // if ($invoice == null) {
        //     $myLogInfo = 'Invoice not found' . implode("\n", $request->all());
        //     file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
        //     $amount = 0.00; //default the amount
        // } else {
        //     $amount = $invoice->amount; //db invoice amount for cross reference
        // }

        // Tell PayFast that this page is reachable by triggering a header 200
        header('HTTP/1.0 200 OK');
        flush();
        try {

            $payfast = new PayFastPayment(
                [
                    'merchantId' => '10034395',
                    'merchantKey' => 's6qs4319o0vzi',
                    //'passPhrase' => 'ab1s1n1yaTravel',
                    //'testMode' => false
                    //'merchantId' => '10028652',
                    // 'merchantKey' => 'qgo0fllvzbcp8',
                    'passPhrase' => 'ab1s1n1yaTravel',
                    'testMode' => false
                ]
            );


            $notification = $payfast->notification->isValidNotification($request->all(), ['amount_gross' => 100]);
            // if ($notification === true) {
            //     // All checks have passed, the payment is successful
            //     $myLogInfo = 'All checks valid \n the payment is successful' . implode("\n", $request->all());
            //     //file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
            //     if ($invoice == null) {
            //         $myLogInfo = 'Invoice not found' . implode("\n", $request->all());
            //         file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
            //     } else {
            //         $invoice->status = "paid"; //update invoice
            //         $invoice->save();
            //     }
            // } else {
            //     // Some checks have failed, check payment manually and log for investigation -> PayFastPayment::$errorMsg
            //     // fwrite($myFile, implode("\n",PayFastPayment::$errorMsg));
            //     $myLogInfo = 'Some checks have failed, check payment manually and log for investigation -> ' . implode("\n", PayFastPayment::$errorMsg) . ' \n request: ' . implode("\n", $request->all());
            //     file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
            //     if ($invoice == null) {
            //         $myLogInfo = 'Invoice not found' . implode("\n", $request->all());
            //         file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
            //     } else {
            //         $invoice->status = "paid"; //update invoice
            //         $invoice->save();
            //     }
            // }
        } catch (Exception $e) {
            // Handle exception
            // fwrite($myFile, 'There was an exception: '.$e->getMessage());
            $myLogInfo = 'There was an exception: ' . $e->getMessage() . ' \n request: ' . implode("\n", $request->all());
            file_put_contents(storage_path() . $name, $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
        $myLogInfo = '<< ------------------------------ saving to db---------------------------------------------------- >>';
        file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);

        //save ITN to DB   
        // $itn = new ITN;
        // $itn->m_payment_id = $request->m_payment_id;
        // $itn->pf_payment_id = $request->pf_payment_id;
        // $itn->status = $request->payment_status;
        // $itn->item = $request->item_name;
        // $itn->description = $request->item_description;
        // $itn->amount = $request->amount_gross;
        // $itn->fee = $request->amount_fee;
        // $itn->net = $request->amount_net;
        // $itn->name = $request->name_first;
        // $itn->surname = $request->name_last;
        // $itn->email = $request->email_address;
        // $itn->merchant_id = $request->merchant_id;
        // $itn->signature = $request->signature;
        // $itn->for = "abisiniya";
        // $itn->save();
        echo "payfast notify ";

        $myLogInfo = '<< ------------------------------ end payfast log ---------------------------------------------------- >>';
        file_put_contents(storage_path() . $name,  $myLogInfo . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    private function handlePaymentNotification($data)
    {
        // Simulate a notification request
        //$request = Request::create(route('notify'), 'POST', $data);

        // Call the notify method internally
        return $this->notify($request);
    }
}


