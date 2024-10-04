<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShuttle;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Http\Resources\ShuttleResource;
use App\Traits\PictureTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\UpdateShuttle;
use App\Http\Requests\AddPic;
use App\Models\Picture;

class ShuttleApiController extends Controller
{
    use PictureTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shuttleList()
    {
        //$shuttles = Shuttle::orderby('created_at', 'DESC')->where('status', 'active')->get();
        //return response()->json(['success' => true, 'data' => $shuttles], 200);
        try {
            $shuttles = Shuttle::orderBy('created_at', 'DESC')
                ->where('status', 'active')
                ->get();

            //return response()->json(['success' => true, 'data' => $shuttles], 200);
            $shuttleResources = ShuttleResource::collection($shuttles);
            return response()->json(['success' => true, 'data' => $shuttleResources], 200);
        } catch (Exception $e) {
            // Handle the exception
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Resource detail @id for unauthenticated user
     * 
     */
    public function singleShuttle($id)
    {
        $shuttle = Shuttle::find($id);
        if (!$shuttle) {
            return response()->json(['success' => false, 'message' => 'Shuttle not found'], 404);
        } else {
            //return response()->json(['success' => true, 'data' => $shuttle], 200);
            $shuttleResource = new ShuttleResource($shuttle);
            return response()->json(['success' => true, 'data' => $shuttleResource], 200);
        }
    }

    /**
     * Store a newly created resource in storage. *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShuttle $request)
    {
        try {
            $shuttle = new Shuttle();
            $shuttle->name = $request->name;
            $shuttle->seater = $request->seater;
            $shuttle->address = $request->address;
            $shuttle->city = $request->city;
            $shuttle->country = $request->country;
            $shuttle->make = $request->make;
            $shuttle->model = $request->model;
            $shuttle->year = $request->year;
            $shuttle->engine_size = $request->engine_size;
            $shuttle->fuel_type = $request->fuel_type;
            $shuttle->weight = $request->weight;
            $shuttle->color = $request->color;
            $shuttle->transmission = $request->transmission;
            $shuttle->price = $request->price;
            $shuttle->status = 'pending';
            $shuttle->user_id = Auth::id();
            $shuttle->save();

            if ($files = $request->file('pictures')) {
                $this->storePicture('Shuttle', $shuttle->id, $files);
            }

            if (!$shuttle) {                  
                return response()->json(['success' => false, 'message' => 'Not created '], 404);
            }   

            if (!empty($shuttle)) {                  
                return response()->json(['success' => true, 'message' => 'Created successfully'], 201);
            }                
            
        } catch (Exception $e) {
             // Handle the exception
             //return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
             return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Authenticate user shuttle list
     * 
     */    
    public function index()
    {
        try {
            $user = Auth::user();
            $shuttles = $user->shuttles()->orderBy('created_at', 'DESC')->get();
            //$apartmentResources = ApartmentResource::collection($apartments);
            // return $this->sendResponse($apartmentResources, 'Apartments');
            if (!$shuttles) {
                return response()->json(['success' => false, 'data' => 'Not found'], 404);
            } else {
                //return response()->json(['success' => true, 'data' => $shuttles], 200);
                $shuttleResources = ShuttleResource::collection($shuttles);
                return response()->json(['success' => true, 'data' => $shuttleResources], 200);
            }
        } catch (Exception $e) {
            //return $this->sendError($th->getMessage());
            //return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    

    /**
     * Display the specified resource for auth user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shuttle = Shuttle::find($id);
        if (!$shuttle) {
            return response()->json(['success' => false, 'message' => 'Shuttle not found'], 404);
        } else {
            //return response()->json(['success' => true, 'data' => $shuttle], 200);
            $shuttleResource = new ShuttleResource($shuttle);
            return response()->json(['success' => true, 'data' => [$shuttleResource]], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateShuttle(UpdateShuttle $request, $id)
    {
        //return $id;
        try {
            $shuttle = Shuttle::findOrFail($id);
            //return  $shuttle;
            //$shuttle = new Shuttle();
            $shuttle->name = $request->name;
            $shuttle->seater = $request->seater;
            $shuttle->address = $request->address;
            $shuttle->city = $request->city;
            $shuttle->country = $request->country;
            $shuttle->make = $request->make;
            $shuttle->model = $request->model;
            $shuttle->year = $request->year;
            $shuttle->engine_size = $request->engine_size;
            $shuttle->fuel_type = $request->fuel_type;
            $shuttle->weight = $request->weight;
            $shuttle->color = $request->color;
            $shuttle->transmission = $request->transmission;
            $shuttle->price = $request->price;
            $shuttle->status = 'pending';
            $shuttle->user_id = Auth::id();
            $shuttle->save();

            if (!empty($shuttle)) {
                return response()->json(['message' => 'Updated'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }        
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        try {
            $bus = Shuttle::findOrFail($id);
            $resp = $bus->delete();
            if (!empty($resp)) {
                return response()->json(['message' => 'Shuttle deleted'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
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
            $shuttleId = $request->shuttle_id;
            Shuttle::findOrFail($shuttleId);
            if ($files = $request->file('pictures')) {
                $this->storePicture('Shuttle', $shuttleId, $files);               
                return response()->json(['message' => 'Successfully added'], 201);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Shuttle not found'], 404);
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
    public function deletePicture($shuttle_id, $picture_id)
    {
        try {
            $shuttle = Shuttle::with('pictures')->findOrFail($shuttle_id);
            if ($shuttle->pictures->count() > 1) {
                $picture = Picture::findOrFail($picture_id);
                if ($picture->picture_id == $shuttle_id) {
                    $this->destroyPicture($picture, 'Shuttle');
                } else {
                    return response()->json(['error' => 'Picture does not belong to this bus!'], 404);
                }
            } else {
                return response()->json(['error' => 'Error: You need to have at least 1 picture'], 404);
            }
            //return back()->with('status', 'Successfully deleted picture');
            return response()->json(['message' => 'Successfully deleted picture'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Shuttle not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
