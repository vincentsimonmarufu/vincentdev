<?php

namespace App\Http\Controllers;

use App\Http\Requests\RouteRequest;
use App\Notifications\UserMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreBus;
use App\Http\Requests\UpdateBus;
use App\Http\Resources\BuslocResource;
use Illuminate\Http\Request;

use App\Traits\PictureTrait;
use App\Traits\CountryTrait;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Busloc;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use App\Http\Requests\BuslocStoreRequest;
use App\Models\Airport;
use App\Models\Ride;
use App\Models\RouteDetail;



class BusController extends Controller
{
    use PictureTrait;
    use CountryTrait; 

    //shuttle search
    public function shuttleSearch(Request $request)
    { 
        
        return $request->all();
        //return view('shuttle_hire');
    }

    // bus search
    public function busSearch(Request $request)
    { 
        //return 'Hello';
        //$startLocation = Busloc::where('buslocation', $request->start_location)->with('routeDetails')->first();
        $startLocation = Busloc::where('buslocation', $request->start_location)->with(['route_details:locids,order'])->get();
        return $startLocation; 
        $endLocation = Busloc::where('buslocation', $request->end_location)->with('routes')->first();
        $departureDate = $request->travel_date;

        if (! $startLocation) {
            $errors['start_location'] = 'The location with the given name does not exist.';
        }
        if (! $endLocation) {
            $errors['end_location'] = 'The location with the given name does not exist.';
        }  

        if (isset($errors)) {
            return redirect()->route('bus_hire')
                ->withErrors($errors)
                ->withInput($request->input());
        }

        //return $request->all();     
        // $type = $request->type;
        // $keyword = $request->keyword;
        // if ($type == 'bus') {
        //     //check if therre is any vehicle
        //     $results = Bus::Where('date', 'LIKE',  "%{$keyword}%") 
        //     ->paginate(12);            
        //     //->where('status', 'active')               
        // }
        // return view('bussearch', compact('results', 'type'));
    }



    public function editBusStop($id)
    {
        $busStop = Busloc::find($id);

        if ($busStop) {
            return response()->json($busStop);
        } else {
            return response()->json(['error' => 'Bus Stop not found'], 404);
        }
    }

    public function updateBusStop(Request $request, $id)
    {
        $busStop = Busloc::find($id);

        if ($busStop) {
            $busStop->buslocation = $request->buslocation;           
            $busStop->save();
            return response()->json(['success' => 'Bus Stop updated successfully']);
        } else {
            return response()->json(['error' => 'Bus Stop not found'], 404);
        }
    }
    
    
    /**
     * drop bus location
     * 
     */
    public function dropBusLocation($id){
        $busStop = Busloc::find($id);

        if ($busStop) {
            $busStop->delete();
            return response()->json(['success' => 'Bus Stop deleted successfully']);
        } else {
            return response()->json(['error' => 'Bus Stop not found'], 404);
        }
    }


    /**
     * drop bus route detail
     * 
     */
    public function dropRouteDetail($id){
        $busStop = RouteDetail::find($id);
       // dd($busStop);

        if ($busStop) {
            $busStop->delete();
            return response()->json(['success' => 'Deleted successfully']);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }


    /**
     * drop bus route/ride detail
     * 
     */
    public function dropRideDetail($id){
        $busStop = Ride::find($id);
       // dd($busStop);

        if ($busStop) {
            $busStop->delete();
            return response()->json(['success' => 'Deleted successfully']);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }


    /**
     * Bus location detail
     * ;
     */
    public function busLocationDetail($id){        
        // Fetch bus location details using the ID
        $busLocation = Busloc::find($id);

        // Check if bus location exists
        if (!$busLocation) {
            return response()->json(['error' => 'Bus location not found'], 404);
        }

        // Return bus location details (could be a view, JSON, etc.)
        // Here we're assuming JSON for an AJAX response
        //return response()->json($busLocation);
        return $busLocation->buslocation;
    }


    /**
     * Bus route detail
     * ;
     */
    public function busRouteDetail($id){        
        // Fetch bus location details using the ID
        $routeDetail = RouteDetail::find($id);

        // Check if bus location exists
        if (!$routeDetail) {
            return response()->json(['error' => 'Route detail not found'], 404);
        }

        // Return bus location details (could be a view, JSON, etc.)
        // Here we're assuming JSON for an AJAX response
        //return response()->json($busLocation);
        return Route::findOrFail($routeDetail->routeid)->name;
    }

    /**
     * Bus ride detail
     * ;
     */
    public function busRideDetail($id){        
        // Fetch bus location details using the ID
        $rideDetail = Ride::find($id);

        // Check if bus location exists
        if (!$rideDetail) {
            return response()->json(['error' => 'Route detail not found'], 404);
        }

        // Return bus location details (could be a view, JSON, etc.)
        // Here we're assuming JSON for an AJAX response
        //return response()->json($busLocation);
        return Route::findOrFail($rideDetail->route_id)->name;
    }

    /**
     * Add bus stop form
     * 
     */
    public function addBusStop(){
        return view('users.buses.bus-location');
    }


    /**
     * Save bus stop
     * 
     */
    public function saveBusStop(BuslocStoreRequest  $request){     
        $busLoc = $request->input('buslocation');
        Busloc::create(['buslocation' => $busLoc]);          
        return redirect()->route('buses.busstops')->with('status', 'Successfully added bus');
    }


    // method's need to perform add action on route add 
    public function getbusStops(){       
        //$options = Busloc::distinct()->select('buslocation')->get();
        $options = Busloc::distinct()->paginate(10); 
        $selectOptions = '<div class="row">
                    <div class="col-md-6 mb-3" style="width: 50%;">
                        <div class="input-group">
                            <select name="locations[]" class="form-control single-select" required>
                                <option value="" disabled selected>Select location</option>';
                                foreach($options as $location){
                                    $selectOptions.='<option value="'. $location->id.'">'.$location->buslocation.'</option>';
                                }
                                $selectOptions.='</select>                           
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" style="width: 25%;">
                        <div class="input-group">
                            <input type="text" name="minutes[]" class="form-control" placeholder="Minutes for departure">                           
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" style="width: 25%;">
                        <div class="input-group">
                            <input type="text" name="price[]" class="form-control" placeholder="Price">  
                            <button class="btn btn-danger remove-field" type="button" style="margin-left:5px;">Remove</button>                      
                        </div>
                    </div>
                <div>'; 
        // Return HTML response
       return response()->json(['selectOptions' => $selectOptions]);
    }


    /**
     * List of bus stops
     * 
     */
    public function busStops(){        
        $busloc = Busloc::distinct()->paginate(10);              
        return view('users.buses.bus-locations', compact('busloc'));
    }


    /**
     * 
     * Add route form
     */
    public function addBusRoute()
    {           
        //$locations = Busloc::all()->sortBy('name');        
        //return view("users.buses.add-route",  ['locations' => BuslocResource::collection($locations)]);
        $locations = Busloc::all();        
        //return view("users.buses.add-route",  ['locations' => BuslocResource::collection($locations)]);
        return view('users.buses.add-route')->with('locations', $locations);
    }


    /**
     * 
     * bus rides form
     * 
     */
    public function busRideForm(){ 
        //$buses = Bus::orderBy('id', 'desc')->get()->pluck('name');
        //$routes = Route::orderBy('id', 'desc')->pluck('name');
        $buses = Bus::whereNotNull('name')->orderBy('id', 'desc')->pluck('name', 'id');
        $routes = Route::whereNotNull('name')->orderBy('id', 'desc')->pluck('name', 'id');
        //print_r($routes);
        return view('users.buses.ride-create', compact('buses','routes'));
    }

    /**
     * 
     * List bus rides
     * 
     */
    public function saveBusRide(Request $request){
        //return $request->all(); 
         $ride = new Ride();
         $ride->bus_id = $request->bus_name;
         $ride->route_id = $request->route_name;
         $ride->departure_time = $request->depart_time;
         $ride->ride_date = $request->depart_date;
         $ride->save();
         //return view('users.buses.ride-list')->with('status','Rides created successfully'); 
         return redirect()->route('buses.ridelist')
            ->with('status', 'Rides has been created!');       
    }

     /**
     * 
     * Save bus rides
     * 
     */
    public function busRideList(){
        //return 'users.buses.bus';
        $rides = Ride::orderBy('id', 'desc')->get();
        //return $rides;
        return view('users.buses.ride-list', compact('rides'));
    }


    /**
     * 
     * Save route data // //$route->buslocs()->attach([
     */
    public function saveBusRoute(Request $request){
        //return $request->all();   
        
        // getting route name    
        $viaCities = $request->name;       
        $viaCitiesArray = explode(',', $viaCities);       
        $pickup = $viaCitiesArray[0];
        $dest = trim($viaCitiesArray[1]);
        $routeFormat = $pickup." -> ".$dest;

        $routeResponse = Route::create(['name' =>  $routeFormat]); 
        $currentRouteId = $routeResponse->id;

        $previousIndex = DB::table('route_details')->max('order');
        $locids = $request->locids;
        $minutes = $request->minutes;
        $prices = $request->prices;
        
        $routeDetail = new RouteDetail;
        $routeDetail->routeid = $currentRouteId;
        $routeDetail->locids = $locids;
        $routeDetail->order =  ++$previousIndex;
        $routeDetail->minutes = $minutes;
        $routeDetail->prices = $prices;
        
        $routeDetail->save();  

        return redirect()->route('buses.routelist')
            ->with('status', 'Route has been created!');
    }



    /**
     * 
     * Save route data // //$route->buslocs()->attach([
     */
    public function saveBusRoute_x(Request $request){

        //return $request->all();

        $viaCities = $request->name;        
        $viaCitiesArray = explode(',', $viaCities);       
        $pickup = $viaCitiesArray[0];
        $dest = trim($viaCitiesArray[1]);
        $routeFormat = $pickup." -> ".$dest; 
        $route = Route::create(['name' =>  $routeFormat]);       
        
        $locations = $request->locations;
               //getting maxing order value
        $previousIndex = DB::table('busloc_route')->max('order');

        // Iterate over the locations and attach them to the route
        collect($locations)->each(function ($location, $index) use ($route, &$previousIndex) {
            // Increment the previous index by 1 for the current location
            $order = ++$previousIndex;
            // Attach the location to the route with the order and other attributes
            $route->buslocs()->attach($location['id'], [
                'order' => $order,
                'minutes_from_departure' => $location['minutes'] ?? 0,
                'prices_from_departure' => $location['prices'] ?? 0,
            ]);
        });        
        
        //return "Hello";
        return redirect()->route('buses.routelist')
            ->withs('status', 'Route has been created!');
    }


    /**
     * bus route list
     * 
     */
    public function busRouteList(){
        $routes = Route::orderBy('id', 'desc')->get();        
        $data = RouteDetail::orderBy('id', 'desc')->get();       
        return view('users.buses.route-list', compact('routes','data'));
    }


    /**
     * Add bus pickup location
     * 
     */
    public function addPickupLocation(){
        return view('users.buses.pickuploc');
    }

    /**
     * Add bus destination
     * 
     */
    public function addDestination(){
        return view('users.buses.destination');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $buses = Bus::orderBy('id', 'Desc')->get();
        } else {
            $buses = Bus::where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get();
        }
        return view('bus.index', compact('buses'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // return "create";
        $countries = $this->getCountries();
        return view('bus.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(StoreBus $request)
    public function store(Request $request)
    {       
        //return 'Hello'; 

        $Bus = new Bus;
        $Bus->name = $request->input('name');
        $Bus->seater = $request->input('seater');
        $Bus->address = $request->input('address');
        $Bus->city = $request->input('city');
        $Bus->country = $request->input('country');
        $Bus->make = $request->input('make');
        $Bus->model = $request->input('model');
        $Bus->year = $request->input('year');
        $Bus->engine_size = $request->input('engine_size');
        $Bus->fuel_type = $request->input('fuel_type');
        $Bus->weight = $request->input('weight');
        $Bus->color = $request->input('color');
        $Bus->transmission = $request->input('transmission');
        $Bus->price = $request->input('price');
        $Bus->status = $request->input('status');
        $Bus->user_id = Auth::id();
        $Bus->save();
        if ($files = $request->file('pictures')) {
            $this->storePicture('Bus', $Bus->id, $files);
        }

        //send notification
        $msg = 'New Bus has been added, to view the view, please click on the button below.';
        $link =  route('buses.edit', $Bus->id);
        $details = [
            'subject' => 'New Bus added',
            'message' => $msg,
            'actionURL' => $link
        ];
        
        //send to owner
        Notification::send(Auth::user(), new UserMail($details));
        //send admin
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New Bus added :  ' . $Bus->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);

        return redirect()->route('buses.index')->with('status', 'Successfully added Bus');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bus = Bus::findOrFail($id);
        $averageRating = $bus->ratings->average('score');
        return view('bus.show', compact('bus', 'averageRating'));
    }

    public function activate($id)
    {
        $Bus = Bus::findOrFail($id);
        $Bus->status = 'active';
        $Bus->save();
        //send notification
        $msg = 'New Bus has been activated, to view the view, please click on the button below.';
        $link =  route('buses.edit', $Bus->id);
        $details = [
            'subject' => 'New Bus activated',
            'message' => $msg,
            'actionURL' => $link
        ];
        $users = User::find($Bus->user_id);
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New Bus activated :  ' . $Bus->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);
        return redirect()->route('buses.index')->with('status', 'Successfully activated Bus');
    }

    public function edit($id)
    {
        $bus = Bus::findOrFail($id);
        $countries = $this->getCountries();
        return view('bus.edit', compact('bus', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBus $request, $id)
    {
        $Bus = Bus::findOrFail($id);
        $Bus->name = $request->input('name');
        $Bus->seater = $request->input('seater');
        $Bus->address = $request->input('address');
        $Bus->city = $request->input('city');
        $Bus->country = $request->input('country');
        $Bus->make = $request->input('make');
        $Bus->model = $request->input('model');
        $Bus->year = $request->input('year');
        $Bus->engine_size = $request->input('engine_size');
        $Bus->fuel_type = $request->input('fuel_type');
        $Bus->weight = $request->input('weight');
        $Bus->color = $request->input('color');
        $Bus->transmission = $request->input('transmission');
        $Bus->price = $request->input('price');
        $Bus->status = $request->input('status');
        // $Bus->user_id = Auth::id();
        $Bus->save();

        //send notification
        $msg = 'New Bus has been updated, to view the view, please click on the button below.';
        $link =  route('buses.edit', $Bus->id);
        $details = [
            'subject' => 'New Bus updated',
            'message' => $msg,
            'actionURL' => $link
        ];
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New Bus updated :  ' . $Bus->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);
        return redirect()->route('buses.index')->with('status', 'Successfully updated Bus');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Bus = Bus::with(['pictures', 'ratings'])->findOrFail($id);
        if ($Bus->pictures->count() > 0) {
            $this->destroyPictures($Bus->pictures, 'Bus');
        }
        if ($Bus->ratings->count() > 0) {
            foreach ($Bus->ratings as $rating) {
                $rating->delete();
            }
        }
        $Bus->delete();

        return redirect()->route('buses.index')->with('status', 'Successfully deleted Bus');
    }
    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        $Bus = Bus::findOrFail($request->input('id'));
        $Bus->status = $request->input('status');
        $Bus->user_id = Auth::id();
        $Bus->save();
        if ($Bus->status == 'active') {
            //send notification

        }

        return redirect()->route('buses.index')->with('status', 'Successfully updated Bus');
    }
}
