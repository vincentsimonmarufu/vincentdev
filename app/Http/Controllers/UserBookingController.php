<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Traits\BookingTrait;
use App\Models\Booking;
use App\Models\User;
use App\Models\Bus;
use App\Models\Shuttle;
use App\Notifications\UserMail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UserBookingController extends Controller
{
    use BookingTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::with('bookings')->orderBy('id', 'Desc')->findOrFail($user_id);
        return view('users.bookings.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            //'end_date' => 'required|date|after:startDate',
            'bookable_type' => 'required|string',
            'bookable_id' => 'required|integer'
        ]);

        if (!Auth::check()) {
            $request->validate([
                'surname' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
                'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            $user = new User;
            $user->surname = $request['surname'];
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->password = bcrypt($request['password']);
            $user->email_verified_at = now();
            $user->save();

            if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

                if (!Auth::attempt(['phone' => $request['phone'], 'password' => $request['password']])) {
                    return back()->withErrors('Failed to log in to the account created, please login to check your booking');
                }
            }
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $bookableType = $request->input('bookable_type');
        $bookableId = $request->input('bookable_id');
        $booking = new Booking;
        $booking->date = date("Y-m-d");
        $booking->start_date = $startDate;
        $booking->end_date = $endDate;
        $booking->reference = Str::random(8);
        $booking->status = "Not Paid";
        $booking->user_id = Auth::id();
        $booking->save();
        $request->session()->put('booking', $booking->id);
        $this->storeBookable($bookableType, $bookableId, $startDate, $endDate, $booking->id, $request->input('km'));
        //send notification
        $msg = 'New Booking request, to view the book request please click on the button below.';
        $link =   route('bookings.show', $booking->id);
        $details = [
            'subject' => 'New Booking request',
            'message' => $msg,
            'actionURL' => $link
        ];
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send to owner
        //$user;
        if ($bookableType == 'Apartment') {
            $aprtment = Apartment::find($bookableId);
            $user = User::find($aprtment->user_id);
            Notification::send($user, new UserMail($details)); //send to owner
        } elseif ($bookableType == 'Vehicle') {
            $vehicle = Vehicle::find($bookableId);
            $user = User::find($vehicle->user_id);
            Notification::send($user, new UserMail($details)); //send to owner
        } elseif ($bookableType == 'Bus') {
            $bus = Bus::find($bookableId);
            $user = User::find($bus->user_id);
            Notification::send($user, new UserMail($details)); //send to owner
        } elseif ($bookableType == 'Shuttle') {
            $shuttle = Shuttle::find($bookableId);
            $user = User::find($shuttle->user_id);
            Notification::send($user, new UserMail($details)); //send to owner
        }
        //Notification::send($user, new UserMail($details)); //send to owner
        //send sms
        $parameters = ['New Booking request :  ' . $booking->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);

        return redirect()->route('users.bookings.index', Auth::id())->with('status', 'Successfully booked');
    }
}
