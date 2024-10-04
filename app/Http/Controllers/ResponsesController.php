<?php

namespace App\Http\Controllers;

use App\Models\FlightRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserMail;
use App\Models\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponsesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reply' => 'required',
            'flightrequest_id' => 'required',
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

        $user = new Response;
        $user->flightrequest_id = $request->input('flightrequest_id');
        $user->reply = $request->input('reply');
        $user->image = $image_name_to_store;
        $user->user_id = Auth::user()->id;
        $user->save();

        //send notification
        $msg = 'New flight response, to view all responses please click on the button below.';
        $link =  route('flightrequests.show', $request->input('flightrequest_id'));
        $details = [
            'subject'=>'New flight response',
           'message' => $msg,
           'actionURL' => $link
        ];
        if(Auth::user()->role =="admin"){
            $flight = FlightRequest::find($request->input('flightrequest_id'));
            $user = User::find($flight->user_id);
             Notification::send($user, new UserMail($details));
        }
        else{
            $users = User::where('role', 'admin')->get();
            Notification::send($users, new UserMail($details));
            //send sms
            $parameters = ['New flight response, flight request : '.$request->input('flightrequest_id')];
            $controller = App::make('\App\Http\Controllers\NotificationsController');
           $data = $controller->callAction('sms',$parameters);
        }
        return back()->with('success', 'Successfully submitted a response');
    }

}
