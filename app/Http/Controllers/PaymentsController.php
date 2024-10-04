<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $payments = Payment::orderBy('id', 'Desc')->get();
        }else{
            $payments = Payment::where('user_id', Auth::user()->id)
            ->orderBy('id', 'Desc')->get();
        }
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        $success = DB::update(
            'update payments set status = ? where id = ?',
            ['paid', $id]
        );

        if ($success > 0)
        {
           return redirect()->back()->with('status', 'Successfully updated your payment status');
           
        }
        else{
             return back()->withErrors('No records changed');
        } 
          
    }

    public function markaspaid($id)
    {
        $success = DB::update(
            'update bookings set status = ? where id = ?',
            ['paid', $id]
        );
        $success = DB::update(
            'update bookinginvoices set status = ? where booking_id = ?',
            ['paid', $id]
        );

        if ($success > 0)
        {
           return redirect()->back()->with('status', 'Successfully updated your payment status');
           
        }
        else{
             return back()->withErrors('No records changed');
        } 
          
    }
    public function create()
    {
        
        return view('payments.initiate');
    }

   
}
