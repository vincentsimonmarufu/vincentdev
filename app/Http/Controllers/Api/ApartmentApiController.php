<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreApartment;
use App\Http\Requests\UpdateApartment;
use App\Http\Requests\AddPic;
use App\Http\Resources\ApartmentResource;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Traits\PictureTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Models\Picture;


class ApartmentApiController extends ResponseController
{

    use PictureTrait;

    /**
     * @api => Add picture API
     * 
     * @param $apartment_id
     * @param token
     * @method Post 
     */
    public function addPicture(AddPic $request)
    {
        //return $request->all();
        try {
            $apartmentId = $request->apartment_id;
            Apartment::findOrFail($apartmentId);
            if ($files = $request->file('pictures')) {
                $this->storePicture('Apartment', $apartmentId, $files);
                return response()->json(['success' => true, 'message' => 'Successfully added picture(s)'], 201);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => 'Not added picture(s)'], 404);
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
    public function deletePicture($apartment_id, $picture_id)
    {
        try {
            $apartment = Apartment::with('pictures')->findOrFail($apartment_id);
            if ($apartment->pictures->count() > 1) {
                $picture = Picture::findOrFail($picture_id);
                if ($picture->picture_id == $apartment_id) {
                    $this->destroyPicture($picture, 'Apartment');
                } else {
                    return response()->json(['success' => false, 'message' => 'Picture does not belong to this apartment!'], 404);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Error: You need to have at least 1 picture'], 404);
            }
            //return back()->with('status', 'Successfully deleted picture');
            return response()->json(['success' => true, 'message' => 'Successfully deleted picture'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }


    /**
     * Manage pictures API_x
     */
    public function managePictures($apartment_id)
    {
        try {
            $apartment = Apartment::orderBy('id', 'Desc')->with('pictures')->findOrFail($apartment_id);
            $apartmentDetail = new ApartmentResource($apartment);
            //return response()->json(['success' =>true,'data' => [$apartmentDetail]], 200);
            return response()->json(['success' => true, 'data' => [$apartmentDetail]], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }


    /**
     * Apartment ratings
     *
     */
    public function ratings(Request $request)
    {
        $apartment_id = $request->input('apartment_id');
        $apartment = Apartment::find($apartment_id);
        $ratings = $apartment->ratings;
        // return RatingResource::collection($ratings);
        return $ratings;
    }

    /**
     * Apartment list / **
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $apartments = Apartment::orderby('created_at', 'DESC')->where('status', 'active')->get();
            $apartmentResources = ApartmentResource::collection($apartments);
            return response()->json(['success' => true, 'data' => $apartmentResources, 'message' => 'Apartment list'], 200);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Apartment detail / **
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $apartment = Apartment::findOrFail($id);
            $apartmentDetail = new ApartmentResource($apartment);
            return response()->json(['success' => true, 'data' => [$apartmentDetail], 'message' => 'Apartment detail'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Auth user apartment list //**
     *
     */
    public function apartmentList()
    {
        try {
            $user = Auth::user();
            $apartments = $user->apartments()->orderBy('created_at', 'DESC')->get();
            $apartmentResources = ApartmentResource::collection($apartments);
            return response()->json(['success' => true, 'data' => $apartmentResources, 'message' => 'Authenticated user apartment list'], 200);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Auth user apartment detail //**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function authApartment($id)
    {
        try {
            $user = Auth::user();
            $apartment = $user->apartments()->findOrFail($id);
            $apartmentDetail = new ApartmentResource($apartment); //new            
            return response()->json(['success' => true, 'data' => [$apartmentDetail], 'message' => 'Authenticated user apartment details'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Activate apartment
     */
    public function activate($id, $status)
    {
        try {
            $apartment = Apartment::findOrFail($id);
            if ($status == 'active') {
                $apartment->status = $status;
                $activeApartment = $apartment->save();
                if ($activeApartment) {
                    return $this->sendResponse('', 'Successfully activated');
                } else {
                    return $this->sendError('Not activated');
                }
            } else {
                return $this->sendError('Input status must be active');
            }
        } catch (Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Create apartment *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartment $request)
    {
        // if ($request->hasFile('pictures')) {
        //     $files = $request->file('pictures');
    
        //     // Array to store uploaded file paths
        //     $filePaths = [];
    
        //     foreach ($files as $file) {
        //         // Validate and store each file as needed
        //         if ($file->isValid()) {
        //             $fileName = $file->getClientOriginalName();
        //             $filePath = $file->storeAs('myfolderName', $fileName); // Store file in storage/app/uploads
        //             $filePaths[] = $filePath; // Store file path for reference
        //         } else {
        //             // Handle file validation error
        //             return response()->json(['message' => 'Invalid file'], 400);
        //         }
        //     }   
        //     return $filePaths; 
        // }

       // return ['data' => $request->all(),'files'=>$request->file("pictures"),'headers' => $request->headers->all(), 'method'=>$request->method()];
        try {
            //Log::info('Request data:', ['data' => $request->all(), 'files' => $request->file("pictures"), 'headers' => $request->headers->all()]);
            $apartment = new Apartment();
            $apartment->name = $request->input('name');
            $apartment->address = $request->input('address');
            $apartment->city = $request->input('city');
            $apartment->country = $request->input('country');
            $apartment->guest = $request->input('guest');
            $apartment->bedroom = $request->input('bedroom');
            $apartment->bathroom = $request->input('bathroom');
            $apartment->price = $request->input('price');
            $apartment->property_type_id = null;
            $apartment->status = 'pending'; //active
            $apartment->user_id = Auth::id();
            //return $apartment;
            $apartment->save();

            if ($files = $request->file("pictures")) {
                $this->storePicture('Apartment', $apartment->id, $files);
            }
            if (!empty($apartment)) {
                return response()->json(['success' => true, 'message' => 'Apartment created'], 200);
            }
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /***
     * Apartment update using PUT method "new update api"
     */
    public function newUpdate(UpdateApartment $request, $id)
    {
        try {
            $apartment = Apartment::findOrFail($id);
            $apartment->name = $request->name;
            $apartment->address = $request->address;
            $apartment->city = $request->city;
            $apartment->country = $request->country;
            $apartment->guest = $request->guest;
            $apartment->bedroom = $request->bedroom;
            $apartment->bathroom = $request->bathroom;
            $apartment->price = $request->price;
            // $apartment->property_type_id = $request->property_type_id;
            $apartment->status = $request->status;
            $apartment->user_id = Auth::id();
            $apartment->save();

            if (!empty($apartment)) {
                return response()->json(['success' => true, 'message' => 'Apartment updated'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
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
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'country' => 'required',
                'guest' => 'required|integer',
                'bedroom' => 'required|integer',
                'bathroom' => 'required|integer',
                'price' => 'required|numeric',
                //'property_type_id' => 'required|integer',
                'status' => 'required',
            ]);

            $apartment = Apartment::findOrFail($id);

            //$apartment = new Apartment();
            $apartment->name = $request->name;
            $apartment->address = $request->address;
            $apartment->city = $request->city;
            $apartment->country = $request->country;
            $apartment->guest = $request->guest;
            $apartment->bedroom = $request->bedroom;
            $apartment->bathroom = $request->bathroom;
            $apartment->price = $request->price;
            // $apartment->property_type_id = $request->property_type_id;
            $apartment->status = $request->status;
            $apartment->user_id = Auth::id();
            $apartment->save();
            //$updateResp = Apartment::where('id', $id)->update($apartment->toArray());
            if ($apartment) {
                return $this->sendResponse('', 'Apartment updated');
            } else {
                return $this->sendError('Not Updated');
            }
        } catch (Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    //Update apartment using PUT method
    public function updateput(Request $request, $id)
    {

        try {
            Apartment::findOrFail($id);
            $validatedData = $request->validate([
                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'country' => 'required',
                'guest' => 'required',
                'bedroom' => 'required',
                'bathroom' => 'required',
                'price' => 'required',
                'property_type_id' => 'required',
                'status' => 'required',
            ]);

            $validatedData['user_id'] = Auth::id();
            $updateResp = Apartment::where('id', $id)->update($validatedData);
            if ($updateResp) {
                return $this->sendResponse('', 'Apartment updated');
            }
        } catch (Exception $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Delete apartment *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $apartments = Apartment::findOrFail($id); //findOrFail
            $resp = $apartments->delete();
            if (!empty($resp)) {
                return response()->json(['success' => true, 'message' => 'Apartment deleted'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }
}
