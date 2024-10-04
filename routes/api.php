<?php

use App\Http\Controllers\Api\ApartmentApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CommonApiController;
use App\Http\Controllers\Api\FlightApiController;
use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\Api\InvoiceApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\RatingApiController;
use App\Http\Controllers\Api\VehicleApiController;
use App\Http\Controllers\Api\UserBookingApiController;
use App\Http\Controllers\Api\BusApiController;
use App\Http\Controllers\Api\ShuttleApiController;
use App\Http\Controllers\Api\AmadeusApiController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Amadeus resource
Route::group(['prefix' => 'v1', 'as' => 'amadeus.'], function () {
    Route::group(['prefix' => 'amadeus'], function () {
        Route::get('/airportlist', [AmadeusApiController::class, 'myAirports'])->name('airportlist');
        //Route::get('/airportswithcountry', [AmadeusApiController::class, 'newAirports'])->name('newairportlist');
        Route::get('/airlinelist', [AmadeusApiController::class, 'myAirlines'])->name('airlinelist');
    });
});

// review and rating routes
Route::group(['prefix' => 'v1', 'as' => 'rating.'], function () {
    Route::group(['prefix' => 'rating'], function () {
        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::post('/add', [RatingApiController::class, 'store'])->name('add');//*
            Route::get('/list/{id}', [RatingApiController::class, 'index'])->name('list');//*
            Route::get('/show/{id}', [RatingApiController::class, 'show'])->name('show');
            Route::put('/update/{id}', [RatingApiController::class, 'show'])->name('update');
            Route::delete('/delete/{id}', [RatingApiController::class, 'destroy'])->name('delete');
            Route::get('/apartment/avgrating/{id}', [RatingApiController::class, 'averageRatingApartment'])->name('apartment.avgrating');
            Route::get('/vehicle/avgrating/{id}', [RatingApiController::class, 'averageRatingVehicle'])->name('vehicle.avgrating');
            Route::get('/bus/avgrating/{id}', [RatingApiController::class, 'averageRatingBus'])->name('bus.avgrating');
            Route::get('/shuttle/avgrating/{id}', [RatingApiController::class, 'averageRatingShuttle'])->name('shuttle.avgrating');//*
        });
    });
});

// 1. Authentication and it's related routes *
Route::group(['prefix' => 'v1', 'as' => 'auth.'], function () {
     // user registration API *
     Route::get('/vcount', [AuthApiController::class, 'countVisitor']);
    // user registration API *
    Route::post('/myregister', [AuthApiController::class, 'registerNew'])->name('myregister');
    // login user API
    Route::post('/login', [AuthApiController::class, 'login'])->name('login');
    // verify OTP
    //Route::post('/otpverify', [AuthApiController::class, 'verifyOtp'])->name('otpverify');
    //resend OTP
    Route::post('otpresend', [AuthApiController::class, 'newOtpResend']);
    // verify Email
    Route::post('/otpverify', [AuthApiController::class, 'verifyOtp'])->name('verifyemail');
    // update mobile no.
    Route::post('/updatephone', [AuthApiController::class, 'updateMobile'])->name('updatephone');

    //Email verify
    Route::get('email/verify/{userid}/{email_verify_token}', [AuthApiController::class, 'verify'])->name('email.verify');
    //Status of email verify
    Route::post('email/verify/status', [AuthApiController::class, 'getEmailVerificationStatus'])->name('email.verify.status');

    Route::post('/email/resend', [AuthApiController::class, 'resend'])->name('email.resend'); //->middleware(['auth:sanctum', 'throttle:6,1']);
    // forgot password API(s)
    Route::post('/forgotpassword/resetlink', [AuthApiController::class, 'forgotPasswordLink'])->name('forgot.password.resetlink');
    Route::post('/password/reset/{token}', [AuthApiController::class, 'reset'])->name('password.reset');
    // end forgot password API(s)
    //forgot password API(s) as implemented Sakshi
    Route::post('/forgotpassword/reset', [AuthApiController::class, 'newReset'])->name('forgotpassword.reset'); // new reset password api
    // forgot password email verify
    Route::post('/forgotpass/emailverify', [AuthApiController::class, 'forgotPasswordEmailVerify'])->name('forgotpass.emailverify'); // new reset password api
    // reset password reset password
    Route::post('/forgotpass/resetpassword', [AuthApiController::class, 'forgotPasswordResetPassword'])->name('forgotpass.resetpassword');
    //protected routes
    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('/userdetail', [AuthApiController::class, 'profile'])->name('userdetail');

        //user detail
        Route::get('/profile', [AuthApiController::class, 'profile'])->name('profile');
        //update profile
        Route::post('/profileupdate', [AuthApiController::class, 'profileUpdate'])->name('profileUpdate');
        //logout
        Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');
    });
});


// Routes for buses
Route::group(['prefix' => 'v1', 'as' => 'buses.'], function () {
        Route::group(['prefix' => 'bus'], function () {

        // buses for non-auth user
        Route::get('list', [BusApiController::class, 'index']);
        
         // list of bus locations api             
         Route::get('/buslocation/list', [BusApiController::class, 'busLocations'])->name('list.buslocation');

        // // buses for auth user
        // Route::get('bus/list', [BusApiController::class, 'busHire']);

        // Bus for Non-Authenticated
        Route::get('/detail/{id}', [BusApiController::class, 'singleBus']); //->name('bus_hire.view');

        //Create bus
        Route::group(['middleware' => ['auth:sanctum']], function () {
            //Route::apiResource('buses', BusApiController::class);

            // add bus location api              
            Route::post('/buslocation/add', [BusApiController::class, 'addBuslocation'])->name('add.buslocation');
            
            // view bus location api              
            Route::get('/buslocation/show/{id}', [BusApiController::class, 'viewBusLocation'])->name('show.buslocation');
            //bus location delete api
            Route::delete('/buslocation/delete/{id}', [BusApiController::class, 'busLocationDestroy'])->name('delete.buslocation');
            // update bus location api
            Route::put('/buslocation/update/{id}', [BusApiController::class, 'updateBusLocation'])->name('update.buslocation');

            // bus add
            Route::post('/add', [BusApiController::class, 'store'])->name('add');

            // bus list for authenticated user
            Route::get('/auth/list', [BusApiController::class, 'busAuthList'])->name('auth.list');

            //bus detail for auth user
            Route::get('/auth/detail/{id}', [BusApiController::class, 'authBus'])->name('auth.detail');

            //bus delete
            Route::delete('/delete/{id}', [BusApiController::class, 'destroy'])->name('delete');

            // bus update
            Route::put('/update/{id}', [BusApiController::class, 'busUpdate'])->name('busupdate');

            // add picture(s)
            Route::post('/pictures/add', [BusApiController::class, 'addPicture'])->name('addpicture');

            // delete picture(s)
            Route::delete('/pictures/{bus_id}/{picture_id}', [BusApiController::class, 'deletePicture'])->name('deletepicture');            
        });      

        //bus routes
        Route::group(['prefix' => 'route', 'middleware' => ['auth:sanctum']], function () {
            // add bus routes detail 
            Route::post('/add/routesdetail', [BusApiController::class, 'addRouteDetail'])->name('routedetail');
            // bus routes detail API
            Route::get('/routeslist', [BusApiController::class, 'busRouteList'])->name('routeslist');
            // delete bus route API
            Route::delete('/delete/{id}', [BusApiController::class, 'deleteBusRouteDetail'])->name('routedelete');
             // show route detail API for auth user
             Route::get('/auth/detail/{id}', [BusApiController::class, 'showRouteDetail'])->name('getroutedetail');
        });

        //bus route rides
        Route::group(['prefix' => 'ride', 'middleware' => ['auth:sanctum']], function () {
            // add bus route/ride api 
            Route::post('/add', [BusApiController::class, 'addRouteRide'])->name('routeride');

            // bus route ride list API
            Route::get('/ridelist', [BusApiController::class, 'busRideList'])->name('rideslist');

            // bus route/ride delete API
            Route::delete('/delete/{id}', [BusApiController::class, 'deleteBusRideDetail'])->name('ridedelete');
             // show route ride detail API for auth user
            Route::get('/auth/ridedetail/{id}', [BusApiController::class, 'showRideDetail'])->name('ridedetail');
        });

    });
});

 
// Routes for Airport shuttle
Route::group(['prefix' => 'v1', 'as' => 'shuttle.'], function () {

    // list of shuttle for UnAuthenticated
    Route::get('shuttles', [ShuttleApiController::class, 'shuttleList']); //->name('bus_hire');
    // list of buses for Non-Authenticated
    //Route::get('shuttles', [BusApiController::class, 'busHire']); //->name('bus_hire');

    // Bus for Non-Authenticated
    //Route::get('bus/{id}', [BusApiController::class, 'singleBus']); //->name('bus_hire.view');

    // Shuttle detail
    Route::get('shuttle/{id}', [ShuttleApiController::class, 'singleShuttle']); //->name('bus_hire.view');


    Route::group(['prefix' => 'shuttle', 'middleware' => ['auth:sanctum']], function () {
        //Route::apiResource('shuttles', ShuttleApiController::class);
        //shuttle list for authenticated user
        Route::get('/auth/list', [ShuttleApiController::class, 'index']);
        //shuttle detail for authenticated user
        Route::get('/auth/detail/{id}', [ShuttleApiController::class, 'show']);
        // create shuttle by authenticated user
        Route::post('/store', [ShuttleApiController::class, 'store']);
        //Route::delete('/shuttledel/{id}', [ShuttleApiController::class, 'destroy']);

        //shuttle delete
        Route::delete('/delete/{id}', [ShuttleApiController::class, 'destroy'])->name('delete');

        // shuttle update
        Route::put('/update/{id}', [ShuttleApiController::class, 'updateShuttle'])->name('shuttleupdate');

        // add picture(s)
        Route::post('/pictures/add', [ShuttleApiController::class, 'addPicture'])->name('addpicture');

        // delete picture(s)
        Route::delete('/pictures/{shuttle_id}/{picture_id}', [ShuttleApiController::class, 'deletePicture'])->name('deletepicture');

    });

    //bus list
    //Route::get('/bus/list', [BusApiController::class, 'index'])->name('list');

    //view bus
    //Route::get('/bus/show/{id}', [BusApiController::class, 'show'])->name('show');
});


//2. Apartment routes
Route::group(['prefix' => 'v1', 'as' => 'apartment.'], function () {

    //apartments list
    Route::get('/apartment/list', [ApartmentApiController::class, 'index'])->name('list');

    //view apartment
    Route::get('/apartment/show/{id}', [ApartmentApiController::class, 'show'])->name('show');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        //apartment list for authenticated user
        Route::get('/apartment/auth/list', [ApartmentApiController::class, 'apartmentList'])->name('auth.list');

        //apartment detail for authenticated user
        Route::get('/apartment/auth/show/{id}', [ApartmentApiController::class, 'authApartment'])->name('auth.show');

        //apartment add *
        Route::post('/apartment/add', [ApartmentApiController::class, 'store'])->name('add');

        //apartment activate
        //Route::get('/apartment/activate/{id}/{status}', [ApartmentApiController::class, 'activate'])->name('activate');

        //apartment update using put
        //Route::put('/apartment/update/{id}', [ApartmentApiController::class, 'updateput'])->name('updateput');

        //apartment update using method post
        Route::post('/apartment/update/{id}', [ApartmentApiController::class, 'update'])->name('updatepost');

        //apartment update using method put New API****
        Route::put('/apartment/update/{id}', [ApartmentApiController::class, 'newUpdate'])->name('newupdate');

        //apartment delete
        Route::delete('/apartment/delete/{id}', [ApartmentApiController::class, 'destroy'])->name('delete');

        //add picture(s)
        //Route::get('/apartment/managepictures/{apartment_id}', [ApartmentApiController::class, 'managePictures'])->name('manageictures');
        Route::post('/apartment/pictures/add', [ApartmentApiController::class, 'addPicture'])->name('addpicture');

        //delete picture(s)
        Route::delete('/apartment/pictures/{apartment_id}/{picture_id}', [ApartmentApiController::class, 'deletePicture'])->name('deletepicture');
    });
});


//3. *Vehicle routes
Route::group(['prefix' => 'v1', 'as' => 'vehicle.'], function () {

    //vehicles list for unauthenticated user
    Route::get('/vehicle/list', [VehicleApiController::class, 'index'])->name('list');

    //vehicle detail for unauthenticated user
    Route::get('/vehicle/show/{id}', [VehicleApiController::class, 'show'])->name('show');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        //vehicles list for authenticated user
        Route::get('/vehicle/auth/list', [VehicleApiController::class, 'vehicleList'])->name('auth.list');

        //vehicle detail for authenticated user
        Route::get('/vehicle/auth/show/{id}', [VehicleApiController::class, 'authVehicle'])->name('auth.show');

        // vehicle add
        Route::post('/vehicle/add', [VehicleApiController::class, 'store'])->name('add');

        //vehicle activate
        //Route::get('/vehicle/activate/{id}', [VehicleApiController::class, 'activate'])->name('activate');

        //vehicle update using POST
        Route::post('/vehicle/update/{id}', [VehicleApiController::class, 'update'])->name('updatepost');

        //vehicle update using PUT
        //Route::put('/vehicle/update/{id}', [VehicleApiController::class, 'updateput'])->name('updateput');

        // vehicle update using method put New API****
        Route::put('/vehicle/update/{id}', [VehicleApiController::class, 'newUpdate'])->name('newupdate');

        //vehicle delete
        Route::delete('/vehicle/delete/{id}', [VehicleApiController::class, 'destroy'])->name('delete');
        //add picture(s)
        Route::post('/vehicle/pictures/add', [VehicleApiController::class, 'addPicture'])->name('addpicture');

        //delete picture(s)
        Route::delete('/vehicle/pictures/{vehicle_id}/{picture_id}', [VehicleApiController::class, 'deletePicture'])->name('deletepicture');
    });
});


//5. flight routes
Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'flight', 'as' => 'flight.'], function () {

        // flight request for non-auth user* /tested
        Route::post('/userflight', [FlightApiController::class, 'store'])->name('add');

        Route::get('airportlist', [FlightApiController::class, 'airportListAPI'])->name('airportlist');

        Route::get('airlinelist', [FlightApiController::class, 'airlinesList'])->name('airlinelist');

        Route::group(['middleware' => ['auth:sanctum']], function () {

            // add/reply - Add/reply API for Amadeus flight booking request
            Route::post('/flightresponse/sendreplynew', [FlightApiController::class, 'sendReplynew'])->name('flight.sendReplynew');

            // View - Show API for Amadeus flight booking request
            Route::get('/aflightreqshow/{flight_booking_id}', [FlightApiController::class, 'myFlightReqtsShowNew'])->name('aflightreqshowid');

            // List - List API for Amadeus flight booking request
            Route::get('/aflightbookingreqlist', [FlightApiController::class, 'myFlightReqtsNew'])->name('aflightbookingreqlist');

            // Add - Add APi for Amadeus flight booking request with passengers
            Route::post('/aflighbookingreqwithpassengers', [FlightApiController::class, 'amadeusFlightBooking'])->name('aflighbookingreqwithpassengers');

            // flight request for auth user* / tested
            Route::post('/auth/userflight', [FlightApiController::class, 'store'])->name('auth.add');             

            // user's flight requests* / tested 
            Route::get('/flightreqs', [FlightApiController::class, 'myFlightReqts'])->name('flightreqs');            

            // amadeus passengers api
            //Route::post('addflightpassenger', [FlightApiController::class, 'addFlightPassengers'])->name('amadeus.addflightpassenger');

            // flight request detail using flightrequest_id* / tested / flight order retrieval api
            Route::get('/show/{ref}', [FlightApiController::class, 'show'])->name('show');

            //flight responses
            //Route::get('/flightResponse/{id}', [FlightApiController::class, 'flightResponse'])->name('flightResponse');

            //flight add/reply message* / API
            Route::post('/flightresponse/sendreply', [FlightApiController::class, 'sendReply'])->name('flight.sendReply');
            // flight add/reply message details
            Route::post('/flightresponse/sendreply/show', [FlightApiController::class, 'sendReplyShow'])->name('flight.sendreply.show');
            //flight delete
            Route::delete('/delete/{id}', [FlightApiController::class, 'destroy'])->name('delete');
        });
    });
});


//6. Booking routes
Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'booking', 'as' => 'booking.'], function () {

        //booking routes for apartment
        Route::group(['prefix' => 'apartment', 'as' => 'apartment.'], function () {

            //apartment booking for non auth user
            Route::post('/booking/newuser', [UserBookingApiController::class, 'store'])->name('newuser');//->middleware('visitor_count');
            // authenticating routes
            Route::group(['middleware' => ['auth:sanctum']], function () {
                //apartment booking for auth user
                Route::post('/booking/authuser', [UserBookingApiController::class, 'store'])->name('authuser');

                //user apartments with booked apartments
                Route::get('/withbooking', [UserBookingApiController::class, 'apartmentsWithBooking'])->name('apartment.withbooking');

                //mybookings
                Route::get('/mybookings', [UserBookingApiController::class, 'myBooking'])->name('mybookings');

                // show mybooking detail using booking id
                Route::get('/mybookingdetail/{id}', [UserBookingApiController::class, 'showMyBookingDetail'])->name('viewmybooking');

                //apartment booking status
                Route::get('/{id}/{status}', [UserBookingApiController::class, 'updateBookableStatus'])->name('bookingstatus');

                // add/send Reply for booking
                Route::post('sendreply', [UserBookingApiController::class, 'sendReply'])->name('sendReply');
                //booked Apartments
                Route::get('bookedapartments', [UserBookingApiController::class, 'bookedApartments'])->name('bookedapartments');
            });
        });

        //booking routes for vehicle
        Route::group(['prefix' => 'vehicle', 'as' => 'vehicle.'], function () {
            //vehicle booking for non auth user *
            Route::post('/booking/newuser', [UserBookingApiController::class, 'vehicleBooking'])->name('newuser');//->middleware('visitor_count');
            Route::group(['middleware' => ['auth:sanctum']], function () {
                //vehicle booking for auth user *
                Route::post('/booking/authuser', [UserBookingApiController::class, 'vehicleBooking'])->name('authuser');

                //user vehicles with booked vehicles
                Route::get('/withbooking', [UserBookingApiController::class, 'vehiclesWithBooking'])->name('vehicle.withbooking');

                //mybookings
                Route::get('/mybookings', [UserBookingApiController::class, 'myBooking'])->name('mybookings');

                // view mybooking detail
                Route::get('/viewmybooking/{id}', [UserBookingApiController::class, 'viewMyBookingDetail'])->name('viewmybooking');

                //vehicle booking status
                Route::get('/{id}/{status}', [UserBookingApiController::class, 'updateBookableStatus'])->name('bookingstatus');

                // add/send Reply for booking
                Route::post('sendreply', [UserBookingApiController::class, 'sendReply'])->name('sendReply');
            });
        });


        //booking routes for bus
        Route::group(['prefix' => 'bus', 'as' => 'bus.'], function () {
            // booking API for non-auth user *
            Route::post('/booking/newuser', [UserBookingApiController::class, 'vehicleBooking'])->name('newuser');

            Route::group(['middleware' => ['auth:sanctum']], function () {
                // booking API for auth user *
                Route::post('/booking/authuser', [UserBookingApiController::class, 'vehicleBooking'])->name('authuser');
                // user buses with booked buses                
                Route::get('/withbooking', [UserBookingApiController::class, 'vehiclesWithBooking'])->name('bus.withbooking');
            });
        });
    });
});


// Payment routes
Route::group(['prefix' => 'v1/payment', 'as' => 'payment.'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        // payment detail
        Route::get('booking/{booking_id}', [PaymentApiController::class, 'showBooking'])->name('bookingshow');
        // booking commision/payments list
        Route::get('paymentlist', [PaymentApiController::class, 'index'])->name('payments');
    });
});

// invoices
Route::group(['prefix' => 'v1/invoice', 'as' => 'invoice.'], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/create', [InvoiceApiController::class, 'store'])->name('store');
        Route::get('/show/{id}', [InvoiceApiController::class, 'show'])->name('show');
        Route::get('/list', [InvoiceApiController::class, 'index'])->name('list');
    });
});

//gallery routes
Route::group(['prefix' => 'v1/gallery', 'as' => 'gallery.'], function () {
    Route::get('/galleries', [GalleryApiController::class, 'index'])->name('uid.gallerys'); //->middleware(['auth:sanctum']);
    Route::post('/create', [GalleryApiController::class, 'store'])->name('add');
});


// common api routes
Route::group(['prefix' => 'v1'], function () {
    //common routes like search, rating, contact
    Route::group(['prefix' => 'common', 'as' => 'common.'], function () {
        //search
        Route::post('search', [CommonApiController::class, 'search'])->name('search');
        //contact
        Route::post('contact', [CommonApiController::class, 'contact'])->name('contact');
    });
});

Route::fallback(function () {
    return response()->json(['message' => 'Not found.'], 200);
});
