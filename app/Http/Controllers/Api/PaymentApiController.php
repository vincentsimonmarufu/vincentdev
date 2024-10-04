<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;
use App\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentApiController extends ResponseController
{
    /**
     * list of payments 
     */
    public function index()
    {
        try {
            $payments = Payment::where('user_id', Auth::user()->id)
                ->orderBy('id', 'Desc')->get();
            $paymentResources = PaymentResource::collection($payments);
            return $this->sendResponse($paymentResources, 'Payment-list');
            //return new PaymentResource();
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }
}
