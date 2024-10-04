<?php

namespace App\Http\Controllers;

use App\Models\FlightBookingResponse;
use Illuminate\Http\Request;

use App\Models\FlightBooking;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class FlightBookingResponsesController extends Controller
{
   
    public function store(Request $request)
    {
        $request->validate([
            'reply' => 'required',
            'flight_booking_id' => 'required',
        ]);

         
        // if($request->hasfile('image'))
        // {
        //     $full_name = $request->file('image')->getClientOriginalName();
        //     $iname = pathinfo($full_name, PATHINFO_FILENAME);
        //     $iextension = $request->file('image')->getClientOriginalExtension();
        //     $image_name_to_store = $iname.'_'.time().'.'.$iextension;
        //     $ipath = $request->file('image')->storeAs('public/responses/', $image_name_to_store);
         
        // }  
        // else{
        //     $image_name_to_store = "";
        // }

        $user = new FlightBookingResponse;
        $user->flight_booking_id = $request->input('flight_booking_id');
        $user->reply = $request->input('reply');
        //$user->image = $image_name_to_store;
        $user->user_id = Auth::user()->id;
        $user->save();

        $flight = FlightBooking::find($request->input('flight_booking_id'));
        //send notification
        $msg = 'New flight response, to view all responses please click on the button below.';
        $link =  route('view.flights', $flight->reference );
        $details = [
            'subject'=>'New flight response',
           'message' => $msg,
           'actionURL' => $link
        ];
        if(Auth::user()->role =="admin"){
            $user = User::find($flight->user_id);
             Notification::send($user, new UserMail($details));
        }
        else{
            $users = User::where('role', 'admin')->get();
            Notification::send($users, new UserMail($details));
            //send sms
            $parameters = ['New flight response, flight Booking Ref : '.$flight->reference];
            $controller = App::make('\App\Http\Controllers\NotificationsController');
           $data = $controller->callAction('sms',$parameters);
        }
        return back()->with('success', 'Successfully submitted a response');
    }
}
