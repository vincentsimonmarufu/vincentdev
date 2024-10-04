<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreVehicle;
use App\Http\Resources\VehicleResource;
use Illuminate\Support\Facades\Log;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\PictureTrait;
use App\Http\Requests\UpdateVehicle;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\AddPic;
use App\Models\Picture;

class VehicleApiController extends ResponseController
{

    use PictureTrait;

    /**
     * @api => Add picture API
     * 
     * @param $vehicle_id
     * @param token
     * @method Post 
     */
    public function addPicture(AddPic $request)
    {
        try {
            $vehicleId = $request->vehicle_id;
            Vehicle::findOrFail($vehicleId);
            if ($files = $request->file('pictures')) {
                $this->storePicture('Vehicle', $vehicleId, $files);
                return response()->json(['success' => true, 'message' => 'Successfully added picture(s)'], 201);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Vehicle not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => 'Not added picture(s)'], 500);
        }
    }

    /**
     * 
     * API => Delete Picture API
     * 
     * @param $vehicle_id
     * @param $picture_id
     * @method POST
     */
    public function deletePicture($vehicle_id, $picture_id)
    {
        try {
            $vehicle = Vehicle::with('pictures')->findOrFail($vehicle_id);
            if ($vehicle->pictures->count() > 1) {
                $picture = Picture::findOrFail($picture_id);
                if ($picture->picture_id == $vehicle_id) {
                    $this->destroyPicture($picture, 'Vehicle');
                } else {
                    return response()->json(['success' => false, 'message' => 'Picture does not belong to this vehicle!'], 404);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Error: You need to have at least 1 picture'], 404);
            }
            //return back()->with('status', 'Successfully deleted picture');
            return response()->json(['success' => true, 'message' => 'Successfully deleted picture'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Vehicle not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }

    /**
     * list of vehicles //**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $vehicles = Vehicle::orderBy('created_at', 'desc')->where('status', 'active')->get();
            $vehicleResources = VehicleResource::collection($vehicles);
            $no_of_vehicles = Vehicle::all()->count();
            return $this->sendResponse($vehicleResources, 'Vehicles list');
            //return response()->json(['status' => true, 'data' => $vehicleResources, 'number_of_vehicle' =>$no_of_vehicles, 'message'=>'List of vehicles']);
            return response()->json(['success' => true, 'data' => $vehicleResources, 'message' => 'Vehicle list'], 200);
        } catch (Exception $th) {
            //return $this->sendError($th->getMessage());
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * list of vehicles for auth user
     */
    public function vehicleList()
    {
        try {
            $vehicles = Auth::user()->vehicles()->orderBy('created_at', 'DESC')->get();
            $vehicleResources = VehicleResource::collection($vehicles);
            //return $this->sendResponse($vehicleResources, 'Authenticated user vehicle list');
            return response()->json(['success' => true, 'data' => $vehicleResources, 'message' => 'Authenticated user vehicle list'], 200);
        } catch (Exception $th) {
            //return $this->sendError($th->getMessage());
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicle $request)
    {
        try {
            //return $request->all();
            $vehicle = new Vehicle;
            $vehicle->name = $request->input('name');
            $vehicle->address = $request->input('address');
            $vehicle->city = $request->input('city');
            $vehicle->country = $request->input('country');
            $vehicle->make = $request->input('make');
            $vehicle->model = $request->input('model');
            $vehicle->year = $request->input('year');
            $vehicle->engine_size = $request->input('engine_size');
            $vehicle->fuel_type = $request->input('fuel_type');
            $vehicle->weight = $request->input('weight');
            $vehicle->color = $request->input('color');
            $vehicle->transmission = $request->input('transmission');
            $vehicle->price = $request->input('price');
            $vehicle->status = 'pending';
            $vehicle->user_id = Auth::id();
            $vehicle->save();

            if ($files = $request->file("pictures")) {
                $this->storePicture('Vehicle', $vehicle->id, $files);
            }
            if ($vehicle) {
                //return $this->sendResponse('Vehicle created.', 'Vehicle created successfully');
                return response()->json(['success' => true, 'message' => 'Vehicle created.'], 200);
            } else {
                return $this->sendError('Vehicle not created');
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Vehicle detail by vehicle id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicleDetail = new VehicleResource($vehicle);
            return response()->json(['success' => true, 'data' => $vehicleDetail], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified apartment detail for non-auth and auth user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function authVehicle($id)
    {
        try {
            $user = Auth::user();
            $vehicle = $user->vehicles()->findOrFail($id);
            $vehicleDetail = new VehicleResource($vehicle); //new            
            return response()->json(['success' => true, 'data' => [$vehicleDetail]], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Vehicle not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update resource using POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'country' => 'required',
                'make' => 'required',
                'model' => 'required',
                'year' => 'required',
                'engine_size' => 'required',
                'fuel_type' => 'required',
                'weight' => 'required',
                'color' => 'required',
                'transmission' => 'required',
                'price' => 'required',
                'status' => 'required',
            ]);

            //$vehicle = new Vehicle();
            $vehicle->name = $request->name;
            $vehicle->address = $request->address;
            $vehicle->city = $request->city;
            $vehicle->country = $request->country;
            $vehicle->make = $request->make;
            $vehicle->model = $request->model;
            $vehicle->year = $request->year;
            $vehicle->engine_size = $request->engine_size;
            $vehicle->fuel_type = $request->fuel_type;
            $vehicle->weight = $request->weight;
            $vehicle->color = $request->color;
            $vehicle->transmission = $request->transmission;
            $vehicle->price = $request->price;
            $vehicle->status = $request->status;
            $vehicle->user_id = Auth::id();
            $vehicle->save();
            //$updateResp = Vehicle::where('id', $id)->update($vehicle->toArray());
            if ($vehicle) {
                return $this->sendResponse('', 'Vehicle updated');
            } else {
                return $this->sendError('Not Updated');
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    // // update resource using PUT
    // public function updateput_x(Request $request, $id)
    // {
    //     try {
    //         Vehicle::findOrFail($id);
    //         $validatedData = $request->validate([
    //             'name' => 'required',
    //             'address' => 'required',
    //             'city' => 'required',
    //             'country' => 'required',
    //             'make' => 'required',
    //             'model' => 'required',
    //             'year' => 'required',
    //             'engine_size' => 'required',
    //             'fuel_type' => 'required',
    //             'weight' => 'required',
    //             'color' => 'required',
    //             'transmission' => 'required',
    //             'price' => 'required',
    //             'status' => 'required',
    //         ]);
    //         $validatedData['user_id'] = Auth::id();
    //         $updateResp = Vehicle::where('id', $id)->update($validatedData);
    //         if ($updateResp) {
    //             return $this->sendResponse('', 'Vehicle updated');
    //         }
    //     } catch (\Exception $th) {
    //         return $this->sendError($th->getMessage());
    //     }
    // }


    /***
     * Apartment update using PUT method "new update api"
     */
    public function newUpdate(UpdateVehicle $request, $id)
    {
        try {
            $vehicle  = Vehicle::findOrFail($id);
            $vehicle->name = $request->name;
            $vehicle->address = $request->address;
            $vehicle->city = $request->city;
            $vehicle->country = $request->country;
            $vehicle->make = $request->make;
            $vehicle->model = $request->model;
            $vehicle->year = $request->year;
            $vehicle->engine_size = $request->engine_size;
            $vehicle->fuel_type = $request->fuel_type;
            $vehicle->weight = $request->weight;
            $vehicle->color = $request->color;
            $vehicle->transmission = $request->transmission;
            $vehicle->price = $request->price;
            $vehicle->status = $request->status;
            $vehicle->user_id = Auth::id();
            $vehicle->save();

            if (!empty($vehicle)) {
                return response()->json(['success' => true, 'message' => 'Vehicle updated'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Vehicle not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
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
            $vehicle = Vehicle::findOrFail($id); //findOrFail
            $resp = $vehicle->delete();
            if (!empty($resp)) {
                return response()->json(['success' => true, 'message' => 'Vehicle deleted'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Vehicle not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }
}
