<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\BookingResponse;
use App\Models\Vehicle;
use App\Models\Bus;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserMail;
use App\Models\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class BookingResponsesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reply' => 'required',
            'booking_id' => 'required',
        ]);

         
        if($request->hasfile('image'))
        {
            $full_name = $request->file('image')->getClientOriginalName();
            $iname = pathinfo($full_name, PATHINFO_FILENAME);
            $iextension = $request->file('image')->getClientOriginalExtension();
            $image_name_to_store = $iname.'_'.time().'.'.$iextension;
            $ipath = $request->file('image')->storeAs('public/responses/', $image_name_to_store);
         
        }  
        else{
            $image_name_to_store = "";
        }

        $user = new BookingResponse;
        $user->booking_id = $request->input('booking_id');
        $user->reply = $request->input('reply');
        $user->image = $image_name_to_store;
        $user->user_id = Auth::user()->id;
        $user->save();

        //send notification
        $msg = 'New booking response, to view all responses please click on the button below.';
        $link =  route('bookings.show', $request->input('booking_id'));
        $details = [
            'subject'=>'New booking response',
           'message' => $msg,
           'actionURL' => $link
        ];
        $booking = Booking::find($request->input('booking_id'));
        if(Auth::user()->id == $booking->user_id){
            $booking = DB::table('bookables')->where('booking_id',$request->input('booking_id'))->first();
            //send to owner
                if($booking->bookable_type == 'App\Models\Apartment'){
                    $aprtment = Apartment::find($booking->bookable_id);
                    $user = User::find($aprtment->user_id);
                }
                elseif($booking->bookable_type == 'App\Models\Vehicle'){
                    $vehicle = Vehicle::find($booking->bookable_id);
                    $user = User::find($vehicle->user_id); 
                }
                elseif($booking->bookable_type == 'App\Models\Bus'){
                    $vehicle = Vehicle::find($booking->bookable_id);
                    $user = User::find($vehicle->user_id); 
                }
                elseif($booking->bookable_type == 'App\Models\Shuttle'){
                    $vehicle = Vehicle::find($booking->bookable_id);
                    $user = User::find($vehicle->user_id); 
                }
             Notification::send($user, new UserMail($details)); //send owner
        }
        else{
            $user = User::find($booking->user_id);
            Notification::send($user, new UserMail($details));//send client
            
        }
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));//send to admin
        //send sms
        $parameters = ['New booking response, booking request : '.$request->input('booking_id')];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
       $data = $controller->callAction('sms',$parameters);
        return back()->with('success', 'Successfully submitted a response');

    }

}
