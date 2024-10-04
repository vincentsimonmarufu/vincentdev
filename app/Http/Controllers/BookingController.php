<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Bookable;
use App\Models\BookingResponse;
use App\Models\Payment;
use App\Models\Bus;
use App\Models\Shuttle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\UserMail;
use Illuminate\Support\Facades\Notification;
use App\Models\Booking;
use App\Models\BookingInvoice;
use App\Models\User;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $bookings = Booking::orderBy('id', 'Desc')->get();
        } else {
            $bookings = Booking::where('user_id', Auth::user()->id)
                ->orderBy('id', 'Desc')->get();
        }
        return view('bookings.index', compact('bookings'));
    }


    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        $responses = BookingResponse::where('booking_id',  $booking->id)->orderBy('created_at', 'Desc')->get();
        $apartmnts = Apartment::with('bookings')
            ->where('user_id', Auth::id())
            ->get();

        $buses = Bus::with('bookings')
            ->where('user_id', Auth::id())
            ->get();

        $vehicles = Vehicle::with('bookings')
            ->where('user_id', Auth::id())
            ->get();

        $shuttles = Shuttle::with('bookings')
            ->where('user_id', Auth::id())
            ->get();

        return view('bookings.show', compact('booking', 'responses', 'vehicles', 'apartmnts', 'buses', 'shuttles'));
    }



    public function updateBookableStatus($bookableId, $status)
    {
        $bookable = DB::update(
            'update bookables set status = ? where id = ?',
            [$status, $bookableId]
        );

        if ($bookable > 0) {
            $book = Bookable::find($bookableId);
            $bookable = Booking::find($book->booking_id);

            //    dd($book);
            //check type
            if ($book->bookable_type == 'App\Models\Apartment') {
                $aprtment = Apartment::find($book->bookable_id);
                $user = User::find($aprtment->user_id);
            } elseif ($book->bookable_type == 'App\Models\Vehicle') {
                $vehicle = Vehicle::find($book->bookable_id);
                $user = User::find($vehicle->user_id);
            } elseif ($book->bookable_type == 'App\Models\Bus') {
                $bus = Bus::find($book->bookable_id);
                $user = User::find($bus->user_id);
            } elseif ($book->bookable_type == 'App\Models\Shuttle') {
                $shuttle = Bus::find($book->bookable_id);
                $user = User::find($shuttle->user_id);
            }
            //send notification
            $msg = 'Booking update, to view the booking status update, please click on the button below.';
            $link =   route('bookings.show', $bookable->id);
            $details = [
                'subject' => 'Booking Status Update',
                'message' => $msg,
                'actionURL' => $link
            ];


            //if approved add to payments
            if ($status == 'Approved') {
                $this->generatebookinginvoice($bookable->id, $bookable->user_id, $book->price);
                $this->payme($bookable->id, $user->id, $book->price * 0.10);
            }
            //4send admin
            $users = User::where('role', 'admin')->get();
            Notification::send($users, new UserMail($details));
            //send to owner of booking...
            $useer = User::find($bookable->user_id);
            Notification::send($useer, new UserMail($details)); //send to owner
            //owner of aprtmnt or vehicle 
            Notification::send($user, new UserMail($details)); //send to owner
            //send sms
            $parameters = ['Booking status update :  ' . $bookable->id];
            $controller = App::make('\App\Http\Controllers\NotificationsController');
            $data = $controller->callAction('sms', $parameters);
            return redirect()->back()->with('status', 'Successfully updated booking status');
        } else {
            return back()->withErrors('No records changed');
        }
    }

    public function generatebookinginvoice($book_id, $user_id, $amount)
    {
        //log the payment
        $payme = new BookingInvoice;
        $payme->booking_id = $book_id;
        $payme->user_id = $user_id; //booker
        $payme->amount = $amount;
        $payme->status = 'pending';
        $payme->save();
    }

    public function payme($book_id, $user_id, $amount)
    {
        //log the payment
        $payme = new Payment;
        $payme->booking_id = $book_id;
        $payme->user_id = $user_id;
        $payme->amount = $amount;
        $payme->status = 'pending';
        $payme->save();

        //send notification
        $msg = 'Awaiting booking payment of ' . $amount . 'usd, to view the booking approved, please click on the button below. Check payments page for more';
        $link =   route('bookings.show', $book_id);
        $details = [
            'subject' => 'Awaiting booking payment ' . $amount . 'usd',
            'message' => $msg,
            'actionURL' => $link
        ];
        //4send admin
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send to owner of booking...
        $user = User::find($user_id);
        Notification::send($user, new UserMail($details)); //send to owner
        //send sms
        $parameters = ['Awaiting booking payment of' . $amount . ' usd booking ID:  ' . $book_id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);
    }
}
