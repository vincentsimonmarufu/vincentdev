<?php

use App\Models\Picture;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    WelcomeController,
    AccessTokenController,
    FlightSearchController,
    AmadeusController,
    KiwiFlightController,
    RapidApiController,
    GetPriceController,
    OrderFlightController,
    UserController,
    HomeController,
    RatingController,
    UserBusController,
    BusController,
    BusPictureController,
    UserShuttleController,
    ShuttleController,
    ShuttlePictureController,
    FlightBookingResponsesController,
    PaypalController,
    ExchangeRateController
};
use App\Http\Controllers\{
    ApartmentPictureController,
    UserApartmentController,
    ApartmentController
};
use App\Http\Controllers\{
    UserVehicleController,
    VehicleController,
    AmenityController,
    LocationController,
    LocationActivityController
};
use App\Http\Controllers\{
    BookingController,
    UserBookingController
};
use App\Http\Controllers\{
    FlightRequestController,
    GalleryController
};
use App\Http\Controllers\{
    NewsletterController,
    PropertyTypeController,
    AnnouncementController
};
use App\Http\Controllers\{
    ResponsesController,
    BookingResponsesController,
    NotificationsController
};
use App\Http\Controllers\{
    PaymentsController,
    InvoicesController
};
use App\Http\Controllers\{
    ITNController,
    PayFastController,
    RolesController,
    PermissionsController
};
use App\Http\Controllers\VehiclePictureController;
use App\Http\Controllers\CorporateTravelController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FlightPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

// Route::get('payfast/success', [PaymentController::class, 'success'])->name('payfast.success');
// Route::get('payfast/cancel', [PaymentController::class, 'cancel'])->name('payfast.cancel');
// Route::post('payfast/notify', [PaymentController::class, 'notify'])->name('payfast.notify');

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome')->middleware('visitor_count');
Route::get('/amadeus/token', [WelcomeController::class, 'getAccessToken']);
//Route::get('/', [WelcomeController::class, 'serverdown']);
Route::get('about', [WelcomeController::class, 'about'])->name('about');
Route::get('flight', [WelcomeController::class, 'flight'])->name('flight');
Route::get('car_hire', [WelcomeController::class, 'carHire'])->name('car_hire');
Route::get('car_hire/{id}/view', [WelcomeController::class, 'singleVehicle'])->name('car_hire.view');
Route::get('bus_hire', [WelcomeController::class, 'busHire'])->name('bus_hire');
Route::get('bus_hire/{id}/view', [WelcomeController::class, 'singleBus'])->name('bus_hire.view');
Route::get('shuttle_hire', [WelcomeController::class, 'shuttleHire'])->name('shuttle_hire');
Route::get('shuttle_hire/{id}/view', [WelcomeController::class, 'singleShuttle'])->name('shuttle.view');
Route::get('contact', [WelcomeController::class, 'contact'])->name('contact');
Route::post('contact', [WelcomeController::class, 'contactUs'])->name('contact-us');
Route::get('gallery', [WelcomeController::class, 'gallery'])->name('gallery');
Route::get('apartments/all', [WelcomeController::class, 'apartments'])->name('apartments.all');
Route::get('apartments/{id}/view', [WelcomeController::class, 'singleApartment'])->name('apartments.view');
Route::post('search', [WelcomeController::class, 'search'])->name('search');
Route::get('search', [WelcomeController::class, 'search']);
Route::get('privacy', [WelcomeController::class, 'privacy'])->name('privacy');
Route::get('infocontact', [WelcomeController::class, 'contactInfo'])->name('contactinfo.index');
Route::get('bookseat', [BusController::class, 'bookseat']);

// corporate travel
Route::get('corporatetravel', [CorporateTravelController::class, 'corporateFare'])->name('corporatetravel.create');
Route::post('corporatetravel', [CorporateTravelController::class, 'corporateFareSave'])->name('corporatetravel.save');


//Auth::routes();
Auth::routes(['verify' => true]);
Route::get('login/redirect', [WelcomeController::class, 'getLoginRoute'])->name('login.redirect');
Route::post('login/redirect', [WelcomeController::class, 'postLoginRoute']);

// Roles and Permissions
Route::resource('roles', RolesController::class)->middleware('auth');
Route::resource('permissions', PermissionsController::class)->middleware('auth');
Route::get('roles/{id}/permissions/edit', [RolesController::class, 'editPermissions'])->name('roles.permissions.edit');
Route::put('roles/{id}/permissions', [RolesController::class, 'updatePermissions'])->name('roles.permissions.update');

Route::post('users.bookings', [UserBookingController::class, 'store']);
Route::post('flightrequests', [FlightRequestController::class, 'store']);
Route::get('/search-flights', [KiwiFlightController::class, 'searchFlights']);
Route::get('/search-Rapidflights', [RapidApiController::class, 'searchFlights']);
Route::get('/search-amadeusflights', [AmadeusController::class, 'searchFlights']);
Route::get('/accesstoken', [AmadeusController::class, 'getAccessToken']);
Route::resource('amadeus', AmadeusController::class)->middleware('auth');
Route::get('/init', AccessTokenController::class)->middleware('auth');
Route::get('/searchi', FlightSearchController::class)->middleware('auth');
Route::get('/search-flight', [FlightSearchController::class, 'index'])->middleware('auth');
Route::post('/searching', FlightSearchController::class)->middleware('auth');
Route::get('/countrycodes', [WelcomeController::class, 'countrycode'])->name('countrycodes');
Route::get('/airlines', [WelcomeController::class, 'airlines'])->name('airlines');
Route::get('/airports', [WelcomeController::class, 'airports'])->name('airports');
Route::get('/myairports', [WelcomeController::class, 'myAirports'])->name('myairports');
Route::get('/search-for-a-flight', [WelcomeController::class, 'index'])->name('flights.searching');

Route::post('/search-for-a-flight', [WelcomeController::class, 'flightsearch'])->name('flights.search');
Route::post('/flight-seatmap', [WelcomeController::class, 'flightSeatMap'])->name('flight-seat-map');
//Route::post('/book-seats', [WelcomeController::class, 'bookSeats'])->name('book-seats');
//Route::post('/confirm-seat', [WelcomeController::class, 'confirmSeatSelection'])->name('confirm.seat');
Route::post('/update-seat-status', [WelcomeController::class, 'updateStatus'])->name('confirm.seat');
//Route::post('/flight-price', [WelcomeController::class, 'flightprice'])->name('flight-price');
Route::get('/flight-price', [WelcomeController::class, 'flightprice'])->name('flight-price');
Route::post('/price', GetPriceController::class)->middleware('auth');
Route::post('/order', OrderFlightController::class)->middleware('auth');
Route::post('/flight-booking', OrderFlightController::class)->name('flightbooking')->middleware('auth');
Route::get('/seats/select', [OrderFlightController::class, 'selectSeat'])->name('seats.select')->middleware('auth');
Route::post('seats/{orderId}', [OrderFlightController::class, 'store'])->name('seats.store')->middleware('auth');
Route::get('/autocomplete', [FlightSearchController::class, 'autocomplete']);
Route::get('/search-airports', [FlightSearchController::class, 'autocomplete']);
Route::get('/multi-city-search', [WelcomeController::class, 'multicity'])->name('multicity');
Route::post('/multi-city-search', [WelcomeController::class, 'flightmulticitysearch'])->name('multicity-search');
Route::get('/my-flights', [OrderFlightController::class, 'index'])->name('my.flights')->middleware('auth');
Route::get('/{ref}/view-flight-booking', [OrderFlightController::class, 'show'])->name('view.flights')->middleware('auth');
Route::get('/ticketissuance/{pnrId}', [OrderFlightController::class, 'ticketissuance'])->name('ticketissuance')->middleware('auth');

Route::post('/modal-login', [WelcomeController::class, 'loginmodal'])->name('modal-login');
Route::post('/modal-register', [WelcomeController::class, 'registermodal'])->name('modal-register');

//subscribe route
Route::post('newsletters/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletters.subscibe');

Route::middleware(['verified'])->group(function () {

    //verify email
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('users/profile', [UserController::class, 'profile'])->name('users.profile')->middleware('auth');
    Route::get('users/verify/{id}', [UserController::class, 'verify'])->name('users.verify')->middleware('auth');
    Route::put('users/profile', [UserController::class, 'updateProfile'])->middleware('auth')->name('updateprofile');
    Route::get('users/type/{type}', [UserController::class, 'type'])->name('users.type')->middleware('auth');
    Route::resource('users', UserController::class)->middleware('auth');

    Route::resource('users.apartments', UserApartmentController::class)->middleware('auth');
    Route::resource('apartments', ApartmentController::class)->middleware('auth');
    Route::get('apartment/activate/{id}', [ApartmentController::class, 'activate'])->name('apartment.activate')->middleware('auth');
    Route::resource('apartments.pictures', ApartmentPictureController::class)->only('index', 'store', 'destroy')->middleware('auth');

    Route::resource('ratings', RatingController::class)->middleware('auth');

    Route::resource('users.vehicles', UserVehicleController::class)->middleware('auth');
    Route::resource('vehicles', VehicleController::class, )->middleware('auth');
    Route::get('vehicle/activate/{id}', [VehicleController::class, 'activate'])->name('vehicle.activate')->middleware('auth');
    Route::resource('vehicles.pictures', VehiclePictureController::class)->middleware('auth');

    Route::resource('users.bus', UserBusController::class)->middleware('auth');
    Route::resource('buses', BusController::class)->middleware('auth');

    Route::get('addbusroute', [BusController::class, 'addBusRoute'])->name('buses.addbusroute')->middleware('auth');
    Route::post('buses/savebusroute', [BusController::class, 'saveBusRoute'])->name('buses.savebusroute')->middleware('auth');
    Route::get('busroutelist', [BusController::class, 'busRouteList'])->name('buses.routelist')->middleware('auth');
    Route::get('buses/showroutedetail/{id}', [BusController::class, 'busRouteDetail'])->name('buses.showroutedetail')->middleware('auth');
    Route::get('buses/droproutedetail/{id}', [BusController::class, 'dropRouteDetail'])->name('buses.droproutedetail')->middleware('auth');
    //Route::get('busroutelist', [BusController::class, 'busRouteList'])->name('buses.routelist')->middleware('auth');
    //Route::get('busroutelist', [BusController::class, 'busRouteList'])->name('buses.routelist')->middleware('auth');
    //bus search
    Route::get('bussearch', [BusController::class, 'busSearch'])->name('bussearch');
    Route::get('shuttlesearch', [BusController::class, 'shuttleSearch'])->name('shuttlesearch');

    Route::get('busrideform', [BusController::class, 'busRideForm'])->name('buses.busrideform')->middleware('auth');
    Route::post('savebusride', [BusController::class, 'saveBusRide'])->name('buses.savebusride')->middleware('auth');
    Route::get('busridelist', [BusController::class, 'busRideList'])->name('buses.ridelist')->middleware('auth');
    Route::get('buses/showridedetail/{id}', [BusController::class, 'busRideDetail'])->name('buses.showridedetail')->middleware('auth');
    Route::get('buses/dropridedetail/{id}', [BusController::class, 'dropRideDetail'])->name('buses.dropridedetail')->middleware('auth');

    Route::get('addbusstop', [BusController::class, 'addBusStop'])->name('buses.addbusstop')->middleware('auth');
    Route::post('buses/savebusstop', [BusController::class, 'saveBusStop'])->name('buses.savebusstop')->middleware('auth');
    Route::get('busstops', [BusController::class, 'busStops'])->name('buses.busstops');//->middleware('auth');
    Route::get('buses/showbusstop/{id}', [BusController::class, 'busLocationDetail'])->name('buses.showbusstop')->middleware('auth');
    Route::get('buses/dropbusstop/{id}', [BusController::class, 'dropBusLocation'])->name('buses.dropbusstop')->middleware('auth');
    Route::get('editbusstop/{id}', [BusController::class, 'editBusStop'])->name('buses.editbusstop')->middleware('auth');
    Route::post('updatebusstop/{id}', [BusController::class, 'updateBusStop'])->name('buses.updatebusstop')->middleware('auth');
    Route::get('getbusstops', [BusController::class, 'getbusStops'])->name('buses.getbusstops')->middleware('auth');

    Route::get('bus/pickuploc', [BusController::class, 'addPickupLocation'])->name('bus.pickuploc')->middleware('auth');
    Route::get('bus/destination', [BusController::class, 'addDestination'])->name('bus.destination')->middleware('auth');

    Route::get('bus/activate/{id}', [BusController::class, 'activate'])->name('bus.activate')->middleware('auth');
    Route::resource('bus.pictures', BusPictureController::class)->middleware('auth');

    Route::resource('users.shuttle', UserShuttleController::class)->middleware('auth');
    Route::resource('shuttles', ShuttleController::class)->middleware('auth');
    Route::get('shuttle/activate/{id}', [ShuttleController::class, 'activate'])->name('shuttle.activate')->middleware('auth');
    Route::resource('shuttle.pictures', ShuttlePictureController::class)->middleware('auth');

    Route::resource('amenities', AmenityController::class)->middleware('auth');
    Route::resource('locations', LocationController::class)->middleware('auth');
    Route::resource('locations.activities', LocationActivityController::class)->middleware('auth');

    Route::resource('bookings', BookingController::class)->middleware('auth');
    Route::resource('users.bookings', UserBookingController::class)->middleware('auth')->except('store');



    Route::resource('flightrequests', FlightRequestController::class)->middleware('auth')->except('store');


    Route::resource('newsletters', NewsletterController::class)->except('edit', 'update');
    Route::post('newsletters/send', [NewsletterController::class, 'send']);

    Route::resource('property_types', PropertyTypeController::class)->middleware('auth');

    Route::get('announcements/sms', [AnnouncementController::class, 'getSendSMS'])->name('announcements.sms')->middleware('auth');
    Route::post('announcements/sms', [AnnouncementController::class, 'postSendSMS'])->middleware('auth');
    Route::resource('announcements', AnnouncementController::class)->middleware('auth');

    Route::get('bookable/{id}/{status}', [BookingController::class, 'updateBookableStatus'])->name('bookable.status')->middleware('auth');
    //replies
    Route::post('send-reply', [ResponsesController::class, 'store'])->name('add_reply')->middleware('auth');
    Route::post('send-flight-reply', [FlightBookingResponsesController::class, 'store'])->name('flight.add_reply')->middleware('auth');

    Route::post('booking-send-reply', [BookingResponsesController::class, 'store'])->name('booking_add_reply')->middleware('auth');
    //notifications
    Route::get('all-notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::get('send', [NotificationsController::class, 'sendNotification']);
    Route::get('read-all-notification', [NotificationsController::class, 'readall'])->name('read_all');
    Route::get('{id}/read-notification', [NotificationsController::class, 'singleNotification'])
        ->name('notification_read'); //mark as read

    Route::get('DatabaseNotificationsMarkasRead', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('databasenotifications.markasread');

    //payments
    Route::get('booking-payments', [PaymentsController::class, 'index'])->name('payments');
    Route::get('status/{id}/payments', [PaymentsController::class, 'status'])->name('payments.status');
    Route::get('status/{id}/marked-payments', [PaymentsController::class, 'markaspaid'])->name('payments.markasstatus');
    Route::post('initiate-payments', [PaymentsController::class, 'initiate'])->name('initiate.payment')->middleware('auth');
    Route::post('initiate-booking-payments', [PaymentsController::class, 'initiatebooking'])->name('initiate.bookingpayment')->middleware('auth');
    Route::post('create-payment', [PaymentsController::class, 'store'])->name('store.payment')->middleware('auth');
    Route::get('paypal-payment-form', [PaypalController::class, 'index'])->name('paypal-payment-form');
    Route::get('paypal-payment-form-submit', [PaypalController::class, 'payment'])->name('paypal-payment-form-submit');
    Route::post('paypal-payment-form-submit', [PaypalController::class, 'payment']);
    //invoices
    Route::get('all-payment-requests', [InvoicesController::class, 'requestpayment'])->name('request.payment')->middleware('auth');
    Route::get('create-request-payment', [InvoicesController::class, 'create'])->name('invoices.create')->middleware('auth');
    Route::post('create-request-payment', [InvoicesController::class, 'store'])->name('invoices.store')->middleware('auth');
    Route::get('all-invoices', [InvoicesController::class, 'index'])->name('invoices')->middleware('auth');

    //Route::get('/{id}/create-payment', 'PaymentsController@create')->name('create.payment')->middleware('auth');

    //payfast
    Route::get('all-itn', [ITNController::class, 'index'])->name('itn')->middleware('auth');
    Route::match(['get', 'post'], 'initiate-now', [PayFastController::class, 'payPayfast'])->name('payfast.payPayfast')->middleware('auth');
    //Route::get('flightPayfast', [PayFastController::class, 'flightPayfastPayment'])->name('payfast.flightPayfast')->middleware('auth');

    //@flight
    //Route::get('/payfast-payment', [PaymentController::class, 'payfastPayment'])->name('payfast.payment');
    //Route::get('/payfast-payment', [FlightPaymentController::class, 'payfastPayment'])->name('payfast.payment');
    // @flight end
});

Route::get('{id}/view-payment-request', [InvoicesController::class, 'show'])->name('invoices.show');
Route::get('/{id}/download-invoice', [InvoicesController::class, 'download'])->name('invoice.download');
Route::any('/notify-booking-payment', [PayFastController::class, 'notifybooking'])->name('notifybooking');
Route::any('/return-payment', [PayFastController::class, 'return'])->name('return');
Route::any('/cancel-payment', [PayFastController::class, 'cancel'])->name('cancel');
Route::any('/notify-payment', [PayFastController::class, 'notify'])->name('notify');

//@deepak
Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.return');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/notify', [PaymentController::class, 'notify'])->name('payment.notify');
// @end deepak

Route::get('/exchange-rate', [ExchangeRateController::class, 'getExchangeRate']);
Route::get('{id}/view-payment-booking', [InvoicesController::class, 'showbookinginvoice'])->name('invoices.booking');

//@new payment
//Route::get('/payment/return', [PayFastController::class, 'return'])->name('payment.return');
//Route::get('/payment/cancel', [PayFastController::class, 'cancel'])->name('payment.cancel');
//Route::post('/payment/notify', [PayFastController::class, 'notify'])->name('payment.notify');

// Route::get('/payment-success', function() {
//     return 'Payment Successful';
// })->name('payment.success');

// Route::get('/payment-cancel', function() {
//     return 'Payment Cancelled';
// })->name('payment.cancel');

// Route::post('/payment-notify', function() {
//     // Handle Payfast IPN (Instant Payment Notification)
//     return 'Payment Notification Received';
// })->name('payment.notify');


// Catch-all route for handling not found routes
// Route::get('/{any}', function () {
//     // You can return a custom 404 view or redirect to another page
//     return 'not found route';
// })->where('any', '.*'); // This regex pattern allows the "any" parameter to contain slashes
