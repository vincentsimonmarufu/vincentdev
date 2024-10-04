<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Str;
use App\Traits\BookingTrait;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\ResponseController;
use App\Models\Apartment;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use App\Models\Bookable;
use App\Models\Payment;
use App\Models\BookingResponse;
use App\Http\Resources\BookableResource;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\MyBookingResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Visitor;
use Illuminate\Support\Facades\Session;

class UserBookingApiController extends ResponseController
{
    use BookingTrait;

    /**
     * Add/reply for booking
     * Method- Post
     */
    public function sendReply(Request $request)
    {
        //return 'send reply';
        $request->validate([
            'reply' => 'required',
            'booking_id' => 'required',
        ]);


        if ($request->hasfile('image')) {
            $full_name = $request->file('image')->getClientOriginalName();
            $iname = pathinfo($full_name, PATHINFO_FILENAME);
            $iextension = $request->file('image')->getClientOriginalExtension();
            $image_name_to_store = $iname . '_' . time() . '.' . $iextension;
            $ipath = $request->file('image')->storeAs('Responses', $image_name_to_store);
        } else {
            $image_name_to_store = "";
        }

        $user = new BookingResponse;
        $user->booking_id = $request->input('booking_id');
        $user->reply = $request->input('reply');
        $user->image = $image_name_to_store;
        $user->user_id = Auth::user()->id;
        $user->save();
        if (!empty($user)) {
            return $this->sendResponse($user, 'Booking response');
        } else {
            return $this->sendError('Something error');
        }
    }

    /**
     * Awaiting Approval API
     */
    public function updateBookableStatus($bookableId, $status)
    {
        //dd(Bookable::all());
        $bookable = DB::update(
            'update bookables set status = ? where id = ?',
            [$status,  $bookableId]
        );
        if ($bookable) {
            $book = Bookable::find($bookableId);
            $booking = Booking::find($book->booking_id);
            $bookStatus = $book->status;
            $user = User::find($booking->user_id);
            //if approved add to payments
            if ($bookStatus == 'Approved') {
                return $this->pay($booking->id, $user->id, $book->price * 0.10);
            }
            if ($bookStatus == 'Checked In') {
                return $this->sendResponse('', 'Now booking status is Checked In.');
            }
            if ($bookStatus == 'Checked Out') {
                return $this->sendResponse('', 'Now booking status is Checked Out.');
            }
            if ($bookStatus == 'Decline') {
                return $this->sendResponse('', 'Now booking status is Declined.');
            }
        } else {
            return $this->sendError('Booking id not found or status already exist ' . $status);
        }
    }

    // private function myMethod()
    private function pay($book_id, $user_id, $amount)
    {
        //return 'payme';
        //log the payment
        $payme = new Payment;
        $payme->booking_id = $book_id;
        $payme->user_id = $user_id;
        $payme->amount = $amount;
        $payme->status = 'pending';
        $payme->save();
        Log::info('Request data:', ['paymeData' => $payme]);
        if ($payme) {
            $msg = 'Awaiting booking payment ' . $amount . ' usd';
            return $this->sendResponse('', $msg);
        } else {
            return $this->sendError('issue to update status');
        }
    }

    /**
     * my bookings details with add/reply message 
     * @param $id is booking id
     */
    public function showMyBookingDetail($id)
    {
        try {
            //get booking by id
            $booking = Bookable::where('booking_id', $id)->orderBy('created_at', 'desc')->get();
            if (!$booking) {
                return response()->json(['success' => false, 'message' => 'booking id not found'], 404);
            }
            // getting add/reply message 
            $responses = BookingResponse::where('booking_id', $id)->orderBy('created_at', 'desc')->get();

            $bookingDetail = ['booking' => BookableResource::collection($booking), 'add_reply_responses' => ResponseResource::collection($responses)];
            return response()->json(['success' => true, 'data' => $bookingDetail], 200);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    // show my booking detail using booking id
    public function showMyBookingDetail_xx($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $responses = BookingResponse::where('booking_id',  $booking->id)->orderBy('created_at', 'Desc')->get();
            // $apartmnts = Apartment::with('bookings')
            //     ->where('user_id', Auth::id())
            //     ->get();
            $bookingDetail = ['booking' => $booking, 'add_reply_responses' => ResponseResource::collection($responses)];
            return response()->json(['success' => true, 'data' => $bookingDetail], 404);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'booking id not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
        // $booking = Booking::findOrFail($id);
        // $responses = BookingResponse::where('booking_id',  $booking->id)->orderBy('created_at', 'Desc')->get();
        // $apartmnts = Apartment::with('bookings')
        //     ->where('user_id', Auth::id())
        //     ->get();

        //         $buses = Bus::with('bookings')
        //             ->where('user_id', Auth::id())
        //             ->get();
        // 
        //         $vehicles = Vehicle::with('bookings')
        //             ->where('user_id', Auth::id())
        //             ->get();
        // 
        //         $shuttles = Shuttle::with('bookings')
        //             ->where('user_id', Auth::id())
        //             ->get();        

    }


    /**
     * User bookings list "my bookings"
     * 
     */
    public function myBooking()
    {
        try {
            //$user_id = Auth::user()->id;
            //$mybookings = User::with('bookings')->orderBy('id', 'Desc')->findOrFail($user_id); //$mybookings->bookings
            $mybookings = Booking::where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get();
            if ($mybookings) {
                return response()->json(['success' => true, 'data' => MyBookingResource::collection($mybookings), 'message' => 'my bookings detail'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Not found'], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }



    /**
     * User apartment list with booking list
     * 
     */
    public function apartmentsWithBooking_w()
    {
        try {
            $apartmentList = null;
            $apartmentList = Apartment::with('bookings')->orderby('created_at', 'DESC')->where('user_id', Auth::id())->get();
            if ($apartmentList) {
                return $this->sendResponse($apartmentList, 'Apartment(s) with booking detail');
            } else {
                return $this->sendError('Not found');
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * User apartment list with booking list
     * 
     */
    public function apartmentsWithBooking()
    {
        //return "Hi";
        try {
            //$apartmentList[] = null;
            $apartmentList = Apartment::with('bookings')->orderby('created_at', 'DESC')->where('user_id', Auth::id())->get();
            if ($apartmentList) {
                return $this->sendResponse($apartmentList, 'Apartment(s) with booking detail');
            } else {
                return $this->sendError('Not found');
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    // My Booked apartments
    public function bookedApartments()
    {
        try {
            if (Auth::id()) {
                $bookedApartments = Apartment::has('bookings')->with('bookings')->get();
                //return response()->json($bookedApartments);
                return response()->json(['success' => true, 'data' => $bookedApartments], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Not found'], 404);
            }
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * User vehicle list with booking list
     * 
     */
    public function vehiclesWithBooking()
    {
        try {
            $vehicleList = Vehicle::with('bookings')->orderby('created_at', 'DESC')->where('user_id', Auth::id())->get();
            if ($vehicleList) {
                return $this->sendResponse($vehicleList, 'Vehicle(s) with booking detail');
            } else {
                return $this->sendError('Not found');
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $apartments = Booking::where('user_id', Auth::user()->id)
                ->orderBy('id', 'Desc')->get();
            //$apartments = Apartment::with('bookings')->orderby('created_at', 'DESC')->where('user_id', Auth::id())->get();
            if ($apartments) {
                return $this->sendResponse($apartments, 'User booking details');
            } else {
                return $this->sendError('Not found');
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }


    /**
     * Apartment booking API for both authenticated and unauthenticate user
     * 
     */
    public function store(Request $request)
    {
        $validator1 = Validator::make([
            'start_date' => $request->start_date, 'end_date' => $request->end_date,
            'bookable_type' => $request->bookable_type, 'bookable_id' => $request->bookable_id
        ], [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'bookable_type' => 'required|string',
            'bookable_id' => 'required|integer'
        ]);

        if ($validator1->fails()) {
            return $this->sendError($validator1->errors(), '', 422);
        }

        try {
            // Start the transaction
            //DB::beginTransaction();

            if (!auth()->user()) {
                $validator = Validator::make([
                    'surname' => $request->surname, 'name' => $request->name, 'email' => $request->email,
                    'phone' => $request->phone, 'password' => $request->password, 'password_confirmation' => $request->password_confirmation
                ], [
                    'surname' => ['required', 'string', 'max:255'],
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
                    'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                if ($validator->fails()) {
                    return $this->sendError($validator->errors(), '', 422);
                }

                $user = new User;
                $user->surname = $request['surname'];
                $user->name = $request['name'];
                $user->email = $request['email'];
                $user->phone = $request['phone'];
                $user->password = bcrypt($request['password']);
                $user->email_verified_at = now();
                $user->save();

                // visitor count          
                $visitorIp = $request->ip();  // Get the visitor's IP address        
                $sessionId = Session::getId();// Get the current session ID        
                $existingVisitor = Visitor::where('ip_address', $visitorIp)
                    ->where('session_id', $sessionId)
                    ->first();// Check if the visitor's IP and session ID combination already exists in the database        
                if (!$existingVisitor) {
                    $url = $request->fullUrl();// If the visitor's IP and session ID combination doesn't exist, count the visit           
                    Visitor::create([
                        'ip_address' => $visitorIp,
                        'session_id' => $sessionId,
                        'url' => $url
                    ]); // Store the visitor's information in the database
                }
                // end of visitor count

                if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

                    if (!Auth::attempt(['phone' => $request['phone'], 'password' => $request['password']])) {
                        return response()->json(['success' => false, 'message' => 'Failed to log in to the account created, please login to check your booking'], 404);
                    }
                }
            }

            $startDate = $request->start_date;
            $endDate = $request->end_date;
            // checking date
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
            $date = Carbon::createFromFormat('Y-m-d', date("Y-m-d"));

            if ($date > $startDate) {
                return response()->json(['success' => false, 'message' => 'Start date should be greater or equal to booking day'], 200);
            }

            if ($startDate > $endDate) {
                return response()->json(['success' => false, 'message' => 'End date should be greater or equal start date. '], 200);
            }

            $bookableType = $request->bookable_type;
            $bookableId = $request->bookable_id;
            $kmt = $request->km;
            $booking = new Booking;
            $booking->date = $date;
            $booking->start_date = $startDate;
            $booking->end_date = $endDate;
            $booking->reference = Str::random(6);
            $booking->status = "Not Paid";
            $userId = Auth::id(); //!auth()->user() ? $user->id : Auth::id();
            $booking->user_id = $userId;

            if (!empty($this->whoCanBook($userId, $bookableId,  $bookableType))) {
                return $this->sendError($this->whoCanBook($userId, $bookableId,  $bookableType));
            }

            $booking->save();
            if ($booking) {
                $this->storeBookable($bookableType, $bookableId, $startDate, $endDate, $booking->id, $kmt);
                $user1 = User::findOrFail($userId);
                $data['token'] = $user1->createToken('Abisiniya')->plainTextToken;
                $data['token_type'] = 'Bearer';
                return response()->json(['success' => true, 'data' => $data, 'message' => 'Thank you for booking request. '], 200);
            }

            // Commit the transaction if everything is successful
            //DB::commit();
        } catch (Exception $th) {
            // Rollback the transaction if an exception occurs
            //DB::rollBack();
            return $this->sendError($th->getMessage());
        }
    }



    /**
     * Apartment booking API for both authenticated and unauthenticate user
     * 
     */
    public function store_x(Request $request)
    {
        $validator1 = Validator::make([
            'start_date' => $request->start_date, 'end_date' => $request->end_date,
            'bookable_type' => $request->bookable_type, 'bookable_id' => $request->bookable_id
        ], [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'bookable_type' => 'required|string',
            'bookable_id' => 'required|integer'
        ]);

        if ($validator1->fails()) {
            return $this->sendError($validator1->errors(), '', 422);
        }

        try {
            if (!auth()->user()) {
                $validator = Validator::make([
                    'surname' => $request->surname, 'name' => $request->name, 'email' => $request->email,
                    'phone' => $request->phone, 'password' => $request->password, 'password_confirmation' => $request->password
                ], [
                    'surname' => ['required', 'string', 'max:255'],
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
                    'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                if ($validator->fails()) {
                    return $this->sendError($validator->errors(), '', 422);
                }

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
                        return response()->json(['success' => false, 'message' => 'Failed to log in to the account created, please login to check your booking'], 404);
                    }
                }
            }


            $startDate = $request->start_date;
            $endDate = $request->end_date;
            // checking date
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
            $date = Carbon::createFromFormat('Y-m-d', date("Y-m-d"));

            if ($date > $startDate) {
                return response()->json(['success' => false, 'message' => 'Start date should be greater or equal to booking day'], 200);
            }

            if ($startDate > $endDate) {
                return response()->json(['success' => false, 'message' => 'End date should be greater or equal start date. '], 200);
            }

            $bookableType = $request->bookable_type;
            $bookableId = $request->bookable_id;
            $kmt = $request->km;
            $booking = new Booking;
            $booking->date = $date;
            $booking->start_date = $startDate;
            $booking->end_date = $endDate;
            $booking->reference = Str::random(6);
            $booking->status = "Not Paid";
            $userId = Auth::id(); //!auth()->user() ? $user->id : Auth::id();
            $booking->user_id = $userId;

            if (!empty($this->whoCanBook($userId, $bookableId,  $bookableType))) {
                return $this->sendError($this->whoCanBook($userId, $bookableId,  $bookableType));
            }

            $booking->save();
            if ($booking) {
                $this->storeBookable($bookableType, $bookableId, $startDate, $endDate, $booking->id, $kmt);
                $user1 = User::findOrFail($userId);
                $data['token'] = $user1->createToken('Abisiniya')->plainTextToken;
                $data['token_type'] = 'Bearer';
                return response()->json(['success' => true, 'data' => $data, 'message' => 'Thank you for booking request. '], 200);
            }
        } catch (Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }


    /**
     * Apartment booking API for both authenticated and unauthenticate user
     * @ 21st March, 2024
     */
    public function store_working(Request $request)
    {
        $validator1 = Validator::make([
            'start_date' => $request->start_date, 'end_date' => $request->end_date,
            'bookable_type' => $request->bookable_type, 'bookable_id' => $request->bookable_id
        ], [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'bookable_type' => 'required|string',
            'bookable_id' => 'required|integer'
        ]);

        if ($validator1->fails()) {
            return $this->sendError($validator1->errors(), '', 422);
        }

        try {
            if (!auth()->user()) {
                $validator = Validator::make([
                    'surname' => $request->surname, 'name' => $request->name, 'email' => $request->email,
                    'phone' => $request->phone, 'password' => $request->password, 'password_confirmation' => $request->password
                ], [
                    'surname' => ['required', 'string', 'max:255'],
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
                    'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                if ($validator->fails()) {
                    return $this->sendError($validator->errors(), '', 422);
                }

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
                        return response()->json(['success' => false, 'message' => 'Failed to log in to the account created, please login to check your booking'], 404);
                    }
                }
            }


            $startDate = $request->start_date;
            $endDate = $request->end_date;
            // checking date
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
            $date = Carbon::createFromFormat('Y-m-d', date("Y-m-d"));

            if ($date > $startDate) {
                return response()->json(['success' => false, 'message' => 'Start date should be greater or equal to booking day'], 200);
            }

            if ($startDate > $endDate) {
                return response()->json(['success' => false, 'message' => 'End date should be greater or equal start date. '], 200);
            }

            $bookableType = $request->bookable_type;
            $bookableId = $request->bookable_id;
            $kmt = $request->km;
            $booking = new Booking;
            $booking->date = $date;
            $booking->start_date = $startDate;
            $booking->end_date = $endDate;
            $booking->reference = Str::random(6);
            $booking->status = "Not Paid";
            $userId = Auth::id(); //!auth()->user() ? $user->id : Auth::id();
            $booking->user_id = $userId;

            if (!empty($this->whoCanBook($userId, $bookableId,  $bookableType))) {
                return $this->sendError($this->whoCanBook($userId, $bookableId,  $bookableType));
            }

            $booking->save();
            if ($booking) {
                $this->storeBookable($bookableType, $bookableId, $startDate, $endDate, $booking->id, $kmt);
                $user1 = User::findOrFail($userId);
                $data['token'] = $user1->createToken('Abisiniya')->plainTextToken;
                $data['token_type'] = 'Bearer';
                return response()->json(['success' => true, 'data' => $data, 'message' => 'Thank you for booking request. '], 200);
            }
        } catch (Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }


    /**
     * Vehicle booking API for both authenticated and unauthenticate user
     * 
     */
    public function vehicleBooking(Request $request)
    {
        //return $request->all();
        $validator1 = Validator::make([
            'start_date' => $request->start_date, 'end_date' => $request->end_date,
            'bookable_type' => $request->bookable_type, 'bookable_id' => $request->bookable_id
        ], [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'bookable_type' => 'required|string',
            'bookable_id' => 'required|integer'
        ]);

        if ($validator1->fails()) {
            //return $this->sendError($validator1->errors(), '', 422);
            return response()->json(['success' => false, 'message' => $validator1->errors()], 422);
        }

        try {
            //DB::beginTransaction();
            if (!auth()->user()) {
                $validator = Validator::make([
                    'surname' => $request->surname, 'name' => $request->name, 'email' => $request->email,
                    'phone' => $request->phone, 'password' => $request->password, 'password_confirmation' => $request->password_confirmation
                ], [
                    'surname' => ['required', 'string', 'max:255'],
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
                    'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                if ($validator->fails()) {
                    return $this->sendError($validator->errors(), '', 422);
                }

                $user = new User;
                $user->surname = $request['surname'];
                $user->name = $request['name'];
                $user->email = $request['email'];
                $user->phone = $request['phone'];
                $user->password = bcrypt($request['password']);
                $user->email_verified_at = now();
                $user->save();

                 // visitor count          
                 $visitorIp = $request->ip();  // Get the visitor's IP address        
                 $sessionId = Session::getId();// Get the current session ID        
                 $existingVisitor = Visitor::where('ip_address', $visitorIp)
                     ->where('session_id', $sessionId)
                     ->first();// Check if the visitor's IP and session ID combination already exists in the database        
                 if (!$existingVisitor) {
                     $url = $request->fullUrl();// If the visitor's IP and session ID combination doesn't exist, count the visit           
                     Visitor::create([
                         'ip_address' => $visitorIp,
                         'session_id' => $sessionId,
                         'url' => $url
                     ]); // Store the visitor's information in the database
                 }
                // end of visitor count

                if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {

                    if (!Auth::attempt(['phone' => $request['phone'], 'password' => $request['password']])) {
                        return response()->json(['success' => false, 'message' => 'Failed to log in to the account created, please login to check your booking'], 404);
                    }
                }
            }


            $startDate = $request->start_date;
            $endDate = $request->end_date;
            // checking date
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
            $date = Carbon::createFromFormat('Y-m-d', date("Y-m-d"));

            if ($date > $startDate) {
                return response()->json(['success' => false, 'message' => 'Start date should be greater or equal to booking day'], 200);
            }

            if ($startDate > $endDate) {
                return response()->json(['success' => false, 'message' => 'End date should be greater or equal start date. '], 200);
            }

            $bookableType = $request->bookable_type;
            $bookableId = $request->bookable_id;
            $kmt = $request->km;
            Log::info('Request data:', ['km' => $kmt]);
            $booking = new Booking;
            $booking->date = $date;
            $booking->start_date = $startDate;
            $booking->end_date = $endDate;
            $booking->reference = Str::random(6);
            $booking->status = "Not Paid";
            $userId = Auth::id(); //!auth()->user() ? $user->id : Auth::id();
            $booking->user_id = $userId;

            if (!empty($this->whoCanBook($userId, $bookableId,  $bookableType))) {
                return $this->sendError($this->whoCanBook($userId, $bookableId,  $bookableType));
            }

            $booking->save();
            if ($booking) {
                $this->storeBookable($bookableType, $bookableId, $startDate, $endDate, $booking->id, $kmt);
                $user1 = User::findOrFail($userId);
                $data['token'] = $user1->createToken('Abisiniya')->plainTextToken;
                $data['token_type'] = 'Bearer';
                return response()->json(['success' => true, 'data' => $data, 'message' => 'Thank you for booking request. '], 200);
            }
            //now commit
           //DB::commit();
        } catch (Exception $th) {
           // DB::rollback();
            return $this->sendError($th->getMessage());
        }
    }


    /**
     * Vehicle booking API for both authenticated and unauthenticate user
     * 
     */
    public function vehicleBooking_working(Request $request)
    {
        //return $request->all();
        $validator1 = Validator::make([
            'start_date' => $request->start_date, 'end_date' => $request->end_date,
            'bookable_type' => $request->bookable_type, 'bookable_id' => $request->bookable_id
        ], [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'bookable_type' => 'required|string',
            'bookable_id' => 'required|integer'
        ]);

        if ($validator1->fails()) {
            //return $this->sendError($validator1->errors(), '', 422);
            return response()->json(['success' => false, 'message' => $validator1->errors()], 422);
        }

        try {
            if (!auth()->user()) {
                $validator = Validator::make([
                    'surname' => $request->surname, 'name' => $request->name, 'email' => $request->email,
                    'phone' => $request->phone, 'password' => $request->password, 'password_confirmation' => $request->password
                ], [
                    'surname' => ['required', 'string', 'max:255'],
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', 'required_without:phone'],
                    'phone' => ['nullable', 'string', 'max:255', 'unique:users', 'required_without:email'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                if ($validator->fails()) {
                    return $this->sendError($validator->errors(), '', 422);
                }

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
                        return response()->json(['success' => false, 'message' => 'Failed to log in to the account created, please login to check your booking'], 404);
                    }
                }
            }


            $startDate = $request->start_date;
            $endDate = $request->end_date;
            // checking date
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);
            $date = Carbon::createFromFormat('Y-m-d', date("Y-m-d"));

            if ($date > $startDate) {
                return response()->json(['success' => false, 'message' => 'Start date should be greater or equal to booking day'], 200);
            }

            if ($startDate > $endDate) {
                return response()->json(['success' => false, 'message' => 'End date should be greater or equal start date. '], 200);
            }

            $bookableType = $request->bookable_type;
            $bookableId = $request->bookable_id;
            $kmt = $request->km;
            Log::info('Request data:', ['km' => $kmt]);
            $booking = new Booking;
            $booking->date = $date;
            $booking->start_date = $startDate;
            $booking->end_date = $endDate;
            $booking->reference = Str::random(6);
            $booking->status = "Not Paid";
            $userId = Auth::id(); //!auth()->user() ? $user->id : Auth::id();
            $booking->user_id = $userId;

            if (!empty($this->whoCanBook($userId, $bookableId,  $bookableType))) {
                return $this->sendError($this->whoCanBook($userId, $bookableId,  $bookableType));
            }

            $booking->save();
            if ($booking) {
                $this->storeBookable($bookableType, $bookableId, $startDate, $endDate, $booking->id, $kmt);
                $user1 = User::findOrFail($userId);
                $data['token'] = $user1->createToken('Abisiniya')->plainTextToken;
                $data['token_type'] = 'Bearer';
                return response()->json(['success' => true, 'data' => $data, 'message' => 'Thank you for booking request. '], 200);
            }
        } catch (Exception $th) {
            //DB::rollback();
            return $this->sendError($th->getMessage());
        }
    }



    /**
     * 
     * Send verification email with link sendVerificationEmail(User $user)
     */
    private function sendVerificationEmail(User $user = null)
    {
        // Generate the verification URL with the verification token       
        $verificationUrl = URL::to('/api/v1/email/verify', ['userid' => $user->id, 'token' => $user->verification_token]);

        // Send the verification email
        Mail::to($user->email)->send(new VerificationEmail($user, $verificationUrl));
    }


    //Checking user can't book own apartment/vehicle    
    private function whoCanBook($userId, $bookableId, $bookableType)
    {
        $userId = $userId;
        $bookableId = $bookableId;
        if (isset($bookableType) && !empty($bookableType)) {
            if ($bookableType == 'Apartment') {
                $user = User::findOrFail($userId);
                $apartment = Apartment::findOrFail($bookableId);
                // return $apartment;
                if ($user->id === $apartment->user->id) {
                    return 'You can\'t book your own apartment';
                }
            }

            if ($bookableType == 'Vehicle') {
                $user = User::findOrFail($userId);
                $vehicle = Vehicle::findOrFail($bookableId);
                //return $vehicle;
                if ($user->id === $vehicle->user->id) {
                    return 'You can\'t book your own vehicle';
                }
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
