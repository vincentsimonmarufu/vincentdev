<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\User;
use App\Http\Requests\StoreBus;
use Illuminate\Support\Facades\Auth;
use App\Traits\PictureTrait;
use App\Http\Resources\BusResource;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\UpdateBus;
use App\Models\Picture;
use App\Http\Requests\AddPic;
use App\Http\Requests\BuslocStoreRequest;
use App\Http\Resources\BuslocResource;
use App\Models\Busloc;
use App\Http\Requests\BuslocUpdateRequest;
use App\Http\Resources\RouteDetailResource;
use App\Http\Resources\RouteResource;
use App\Models\Ride;
use App\Models\Route;
use App\Models\RouteDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RideResource;

class BusApiController extends Controller
{
    use PictureTrait;


    /**
     *  delete route/ride API*
     * 
     */
    public function deleteBusRideDetail($id){
        //return $id;       
        try {
            $routeDetail = Ride::findOrFail($id);
            $resp = $routeDetail->delete();
            if (!empty($resp)) {
                return response()->json(['message' => 'Deleted'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Ride detail not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }   

    }

    /**
     * Show route/ride API*
     * 
     */
    public function showRideDetail($id){
        try {
            $rideDetail = Ride::findOrFail($id);            
            if (!$rideDetail) {
                return response()->json(['error' => 'Not found'], 404);
            }            
            return new RideResource($rideDetail);           
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Ride detail not found'], 404);
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        } 
    }


    /**
     * bus rides list
     * 
     **/        
    public function busRideList(){             
        return RideResource::collection(Ride::get());
    }


    /**
     *  routedetail delete API*
     * 
     */
    public function deleteBusRouteDetail($id){
        //return $id;       
        try {
            $routeDetail = RouteDetail::findOrFail($id);
            $resp = $routeDetail->delete();
            if (!empty($resp)) {
                return response()->json(['message' => 'Deleted'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Route detail not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }   

    }

    /**
     * Show routedetail API*
     * 
     */
    public function showRouteDetail($id){
        try {
            $routeDetail = RouteDetail::findOrFail($id);            
            if (!$routeDetail) {
                return response()->json(['error' => 'Not found'], 404);
            }            
            return new RouteDetailResource($routeDetail);           
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Route detail not found'], 404);
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        } 
    }


    /**
     * List bus route list API *
     *  
     */    
    public function busRouteList()
    { 
        //getting routes details
        $data = RouteDetail::orderBy('id', 'desc')->get();      
       
        $processedData = [];

        // Loop through each item and process locids, minutes, and prices
        foreach ($data as $item) {
            $processedData[] = [
                'id' => $item['id'],  
                'routeId' =>$item['routeid'],             
                'routeName' => Route::findOrFail($item['routeid'])->name,
                'locids' => count(is_string($item['locids']) ? explode(', ', $item['locids']) : $item['locids']),
                'minutes' => array_sum(is_string($item['minutes']) ? explode(', ', $item['minutes']) : $item['minutes']),
                'prices' => array_sum(is_string($item['prices']) ? explode(', ', $item['prices']) : $item['prices']),
            ];
        }       
        //return response()->json($processedData); 
        $responseData = [
            'routes' =>  $processedData,
        ];

        // Return the response as JSON
        return response()->json($responseData);   
    }   


    /**
     * Create bus routedetail API *
     * 
     */
    public function addRouteDetail(Request $request)
    {
        try {
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

            if(!empty($routeDetail)){
                return response()->json(['routesDetail' => [new RouteDetailResource($routeDetail)], 'message' => 'Created'], 201);               
            }else{
                return response()->json(['error' => 'Route detail not created'], 404);
            }            
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }       
    }
    
    

    /**
     * 
     * View/show bus location API
     */
    public function viewBusLocation($id){
        try {
            $busLocation = Busloc::findOrFail($id);            
            if (!$busLocation) {
                return response()->json(['error' => 'Bus location not found'], 404);
            }            
            return new BuslocResource($busLocation);           
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Bus stop not found'], 404);
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }         
    }

    /**
     * Delete bus location API
     */
    public function busLocationDestroy($id){

        try {
            $busStop = Busloc::findOrFail($id);
            if ($busStop) {
                $busStop->delete();
                return response()->json(['message' => 'Bus Stop deleted successfully']);
            } else {
                return response()->json(['error' => 'Bus Stop not found'], 404);
            }        
            
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Bus stop not found'], 404);
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        } 
        
    }


    /**
     * Update bus location API
     */
    public function updateBusLocation(BuslocUpdateRequest $request, $id){  
        
        try{
            $busStop = Busloc::findOrFail($id);

        if ($busStop) {
            $busStop->buslocation = $request->buslocation;           
            $busStop->save();
            return response()->json(['message' => 'Bus Stop updated successfully']);
        } 
        }catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Bus stop not found'], 404);
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }     
        
    }


    /**
     * add bus route/ride api
     * 
     */
    public function addRouteRide(Request $request){        
        try{
            $ride = new Ride();
            $ride->route_id = $request->route_id;
            $ride->bus_id = $request->bus_id;
            $ride->departure_time = $request->departure_time;
            $ride->ride_date = $request->ride_date; 
            $ride->save();          
            if(!empty($ride)){
                return response()->json(['message' => 'Created'], 201);               
            }else{
                return response()->json(['error' => 'Not created'], 404);
            }            
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    /**
     * add bus location api
     * 
     */
    public function addBuslocation(BuslocStoreRequest $request){
        //return $request->buslocation;
        $busLocation = $request->buslocation;
        $busLoc = Busloc::create(['buslocation' =>  $busLocation]);        
        return new BuslocResource($busLoc);
    }

    /**
     * list bus location API
     * 
     */
    public function busLocations(){             
        return BuslocResource::collection(Busloc::get());
    }



    /**
     * @api => Add picture API
     * 
     * @param $bus_id
     * @param token
     * @method Post 
     */
    public function addPicture(AddPic $request)
    {
        //return $request->all();
        try {
            $busId = $request->bus_id;
            Bus::findOrFail($busId);
            if ($files = $request->file('pictures')) {
                $this->storePicture('Bus', $busId, $files);
                //return response()->json(['success' => true, 'message' => 'Successfully added picture(s)'], 201);
                return response()->json(['message' => 'Successfully added'], 201);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Bus not found'], 404);
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    /**
     * 
     * API => Delete Picture API
     * 
     * @param $apartment_id
     * @param $picture_id
     * @method POST
     */
    public function deletePicture($bus_id, $picture_id)
    {
        try {
            $bus = Bus::with('pictures')->findOrFail($bus_id);
            if ($bus->pictures->count() > 1) {
                $picture = Picture::findOrFail($picture_id);
                if ($picture->picture_id == $bus_id) {
                    $this->destroyPicture($picture, 'Bus');
                } else {
                    return response()->json(['error' => 'Picture does not belong to this bus!'], 404);
                }
            } else {
                return response()->json(['error' => 'Error: You need to have at least 1 picture'], 404);
            }
            //return back()->with('status', 'Successfully deleted picture');
            return response()->json(['message' => 'Successfully deleted picture'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Bus not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    // buses @Non-Authenticated *
    public function busHire()
    {
        $buses = Bus::orderby('created_at', 'DESC')->where('status', 'active')->get();
        $busResources = BusResource::collection($buses);
        return response()->json(['success' => true, 'data' => $busResources], 200);
        //return $this->sendResponse($buses, 'Bus list');
    }

    /**
     * Bus detail @Non-Authenticated *
     * @param $bus_id
     * 
     */
    public function singleBus($bus_id)
    {
        $bus = Bus::find($bus_id);
        if (!$bus) {
            return response()->json(['success' => false, 'message' => ' Bus not found'], 404);
        }
        $busResource = new BusResource($bus);
        return response()->json(['success' => true, 'data' => $busResource, 'message' => 'Bus detail'], 200);
    }

    // Using model binding
    public function singleBus_x(User $user)
    {
        //return $user;
        $bus = Bus::find($user);
        return $bus;

        // if (!$bus) {
        //     return response()->json(['success' => false, 'message' => ' Bus not found'], 404);
        // }
        // return response()->json(['success' => true, 'data' => $bus, 'message' => 'Bus detail'], 200);
        //return $user;
    }


    /**
     * Display a listing of the bus for non-auth user
     *
     * 1*
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $buses = Bus::orderby('created_at', 'DESC')->where('status', 'active')->get();           
            return BusResource::collection($buses);
            //return $buses;       
        } catch (Exception $th) {          
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * Bus detail for auth user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function authBus($id)
    {

        try {
            $user = Auth::user();
            $bus = $user->buses()->findOrFail($id);
            //return [new BusResource($bus)];
            return response()->json(['data' => [new BusResource($bus)]]);
            //return BusResource::collection($buses);          
            //return response()->json(['success' => true, 'data' => [$busDetail], 'message' => 'Authenticated user apartment details'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Bus not found'], 404);
        } catch (Exception $th) {
            //return response()->json(['message' => $th->getMessage()], 500);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }

        // try {
        //     $user = Auth::user();
        //     $apartment = $user->apartments()->findOrFail($id);
        //     $apartmentDetail = new ApartmentResource($apartment); //new            
        //     return response()->json(['success' => true, 'data' => [$apartmentDetail], 'message' => 'Authenticated user apartment details'], 200);
        // } catch (ModelNotFoundException $e) {
        //     return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        // } catch (Exception $th) {
        //     return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        // }
    }


    /**
     * Bus list for auth user
     * 
     * 1*
     */
    public function busAuthList(){
        try {
            $user = Auth::user();
            $buses = $user->buses()->orderBy('created_at', 'DESC')->get();          
            return BusResource::collection($buses);
        } catch (Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     * 1*
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBus $request)
    {
        //return $request->all();
        try {
            //Log::info('Request data:', ['data' => $request->all(), 'files' => $request->file("pictures"), 'headers' => $request->headers->all()]);
            $bus = new Bus;
            $bus->name = $request->name;
            $bus->seater = $request->seater;
            $bus->address = $request->address;
            $bus->city = $request->city;
            $bus->country = $request->country;
            $bus->make = $request->make;
            $bus->model = $request->model;
            $bus->year = $request->year;
            $bus->engine_size = $request->engine_size;
            $bus->fuel_type = $request->fuel_type;
            $bus->weight = $request->weight;
            $bus->color = $request->color;
            $bus->transmission = $request->transmission;
            $bus->price = $request->price;
            $bus->status = 'pending'; // $request->input('status');
            $bus->user_id = Auth::id();
            $bus->save();

            if ($files = $request->file("pictures")) {
                $this->storePicture('Bus', $bus->id, $files);
            }
            if (!empty($bus)) {             
                return response()->json(['message' => 'Created'], 201);
            }
        } catch (Exception $th) {            
            //return response()->json(['error' => $th->getMessage()], 500);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    /**
     * Update bus API 1*
     *  
     */
    public function busUpdate(UpdateBus $request, $id)
    {
        try {
            $bus = Bus::findOrFail($id);

            $bus->name = $request->name;
            $bus->seater = $request->seater;
            $bus->address = $request->address;
            $bus->city = $request->city;
            $bus->country = $request->country;
            $bus->make = $request->make;
            $bus->model = $request->model;
            $bus->year = $request->year;
            $bus->engine_size = $request->engine_size;
            $bus->fuel_type = $request->fuel_type;
            $bus->weight = $request->weight;
            $bus->color = $request->color;
            $bus->transmission = $request->transmission;
            $bus->price = $request->price;
            $bus->status = 'pending'; // $request->input('status');
            $bus->user_id = Auth::id();
            $bus->save();

            if (!empty($bus)) {
                return response()->json(['message' => 'Updated'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Bus not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    /**
     * Delete bus 1*
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $bus = Bus::findOrFail($id); //findOrFail
            $resp = $bus->delete();
            if (!empty($resp)) {
                return response()->json(['message' => 'Bus deleted'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Bus not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
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
   
}
