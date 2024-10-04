<?php

namespace App\Http\Controllers;

use App\Notifications\UserMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\FlightRequest;
use App\Models\FlightBooking;

class FlightRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //dd($flightRequests);
        if (Auth::user()->role == 'admin') {
            $flightRequests = FlightRequest::orderBy('id', 'Desc')->with('user')->get();
        } else {
            //$flightRequests = FlightRequest::orderBy('id', 'Desc')->where('user_id', Auth::user()->id)->get();
            $flightRequests = FlightBooking::orderBy('id', 'Desc')->where('user_id', Auth::user()->id)->get();
        }
        return view('flight_requests.index', compact('flightRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('flight_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        if (Auth::check()) {
            $user = User::findOrFail(Auth::id());
            $request->validate([
                'airline' => 'required',
                'from' => 'required',
                'to' => 'required',
            ]);
        } else {
            $request->validate([
                'surname' => 'string|required|max:191',
                'name' => 'string|required|max:191',
                //'phone' => 'string|required|max:191|unique:users',
                'email' => 'email|string|required|max:191|unique:users',
                'password' => 'string|required|max:191|confirmed',
                'from' => 'required',
                'to' => 'required',
                'airline' => 'required',
            ]);
            $user = new User;
            $user->surname = $request->input('surname');
            $user->name = $request->input('name');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->email_verified_at = now();
            $user->save();
        }

        $flightRequest = new FlightRequest;
        $flightRequest->from = $request->input('from');
        $flightRequest->to = $request->input('to');
        $flightRequest->airline = $request->input('airline');
        $flightRequest->departure_date = $request->input('departure_date');
        $flightRequest->return_date = $request->input('return_date');
        $flightRequest->travel_class = $request->input('travel_class');
        $flightRequest->trip_option = $request->input('trip_option');
        $flightRequest->message = $request->input('message');
        $flightRequest->user_id = $user->id;
        $flightRequest->save();

        //send notification
        $msg = 'New flight request, to view the flight request please click on the button below.';
        $link =  route('flightrequests.show', $flightRequest->id);
        $details = [
            'subject' => 'New flight request',
            'message' => $msg,
            'actionURL' => $link
        ];
        if (Auth::check()) {
            if (Auth::user()->role == "admin") {
                Notification::send($user, new UserMail($details));
            } else {
                Notification::send($user, new UserMail($details));
                $users = User::where('role', 'admin')->get();
                Notification::send($users, new UserMail($details));
                //send sms
                $parameters = ['New flight request :  ' . $flightRequest->id];
                $controller = App::make('\App\Http\Controllers\NotificationsController');
                $data = $controller->callAction('sms', $parameters);
            }
        } else {
            $users = User::where('role', 'admin')->get();
            Notification::send($users, new UserMail($details));
            //send sms
            $parameters = ['New flight request :  ' . $flightRequest->id];
            $controller = App::make('\App\Http\Controllers\NotificationsController');
            $data = $controller->callAction('sms', $parameters);
        }

        return back()->with('status', 'Successfully submitted flight request');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //return $id;
    //     $flightRequest = FlightRequest::with('user')->findOrFail($id);
    //     //return $flightRequest;
    //     $responses = Response::where('flightrequest_id',  $flightRequest->id)->orderBy('created_at', 'Desc')->get();
    //     return view('flight_requests.show', compact('flightRequest', 'responses'));
    // }


    public function show($id)
    {
        //return $id;
        $flightRequest = FlightBooking::with('user')->findOrFail($id);
        //return $flightRequest;
        $responses = Response::where('flightrequest_id',  $flightRequest->id)->orderBy('created_at', 'Desc')->get();
        return view('flight_requests.show', compact('flightRequest', 'responses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flightRequest = FlightRequest::with('user')->findOrFail($id);
        return view('flight_requests.edit', compact('flightRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $flightRequest = FlightRequest::findOrFail($id);
        $flightRequest->from = $request->input('from');
        $flightRequest->to = $request->input('to');
        $flightRequest->airline = $request->input('airline');
        $flightRequest->departure_date = $request->input('departure_date');
        $flightRequest->return_date = $request->input('return_date');
        $flightRequest->travel_class = $request->input('travel_class');
        $flightRequest->trip_option = $request->input('trip_option');
        $flightRequest->message = $request->input('message');
        // $flightRequest->user_id = $user->id;
        $flightRequest->save();

        return back()->with('status', 'Successfully updated flight request');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flightRequest = FlightRequest::findOrFail($id);
        $flightRequest->delete();

        return back()->with('status', 'Successfully deleted flight request');
    }
}
