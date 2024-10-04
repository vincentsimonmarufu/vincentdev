<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\RatingResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Apartment;
use App\Models\Vehicle;
use App\Models\Bus;
use App\Models\Shuttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class RatingApiController extends ResponseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            $user_id = auth()->id();
            $ratings = Rating::where('user_id', $user_id)->where('rating_id', $id)
                ->orderBy('id', 'desc')->get();
            return response()->json(['success' => true, 'data' => $ratings], 200);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }


    /**
     * Add review API for apartment and vehicle
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        try {           
            // Validation rules // |exists:ratings,rating_id
            $validatedData = $request->validate([
                'rating_type' => 'required|string|max:255',
                'rating_id' => 'required|integer',
                'score' => 'required|integer',
                'comment' => 'required',
            ]);

            // Create new record 
            $rating = new Rating;
            $rating->rating_type = $validatedData['rating_type'];
            $rating->rating_id = $validatedData['rating_id'];
            $rating->score = $validatedData['score'];
            $rating->comment = $validatedData['comment'];
            $rating->user_id = Auth::id();
            $rating->save();
            if ($rating) {
                return response()->json(['success' => true, 'message' => 'Added'], 201);
            }
        }catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Shuttle not found'], 404);
        }catch (Exception $th) {            
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
        try {
            $rating = Rating::findOrFail($id);
            return response()->json(['success' => true, 'data' => $rating], 200);
        } catch (Exception $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }


    /** 
     * Average rating for Apartment
     * 
     */
    public function averageRatingApartment($id)
    {
        try {
            $apartment = Apartment::with('ratings.user')->findOrFail($id);
            $averageRating = number_format($apartment->ratings->average('score'),3);
            //$rating = Rating::findOrFail($id);
            $rating = RatingResource::collection(Apartment::find($id)->ratings);
            return response()->json(['success' => true, 'data' => ['avgRating' => $averageRating, 'ratingDetails' => $rating]], 200);
        } catch (ModelNotFoundException $e) {
            //return response()->json(['success' => false, 'message' => 'Apartment not found'], 404);
            return response()->json(['error' => 'Apartment not found'], 404);
        } catch (Exception $th) {
            //return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    /** 
     * Average rating for Vehicle
     * 
     */
    public function averageRatingVehicle($id)
    {
        try {
            $vehicle = Vehicle::with('ratings.user')->findOrFail($id);
            $averageRating = number_format($vehicle->ratings->average('score'), 3);
            //$rating = Rating::findOrFail($id);
            $rating = RatingResource::collection(Vehicle::find($id)->ratings);
            return response()->json(['success' => true, 'data' => ['avgRating' => $averageRating, 'ratingDetails' => $rating]], 200);
        } catch (ModelNotFoundException $e) {
            //return response()->json(['success' => false, 'message' => 'Vehicle not found'], 404);
            return response()->json(['error' => 'Vehicle not found'], 404);
        } catch (Exception $th) {
            //return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    /** 
     * Average rating for Bus
     * 
     */
    public function averageRatingBus($id)
    {
        try {
            $bus = Bus::with('ratings.user')->findOrFail($id);
            $averageRating = number_format($bus->ratings->average('score'),3);
            //$averageRating = RatingResource::collection($bus->ratings->average('score'));
            //$rating = Rating::findOrFail($id);         
            $rating = RatingResource::collection(Bus::find($id)->ratings);
            return response()->json(['success' => true, 'data' => ['avgRating' => $averageRating, 'showRating' => $rating]], 200);           
        } catch (ModelNotFoundException $e) {            
            return response()->json(['error' => 'Bus not found'], 404);
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    /** 
     * Average rating for Shuttle
     * 
     */
    public function averageRatingShuttle($id)
    {
        try {
            $shuttle = Shuttle::with('ratings.user')->findOrFail($id);
            $averageRating = number_format($shuttle->ratings->average('score'),3);
            //$averageRating = RatingResource::collection($bus->ratings->average('score'));
            //$rating = Rating::findOrFail($id);         
            $rating = RatingResource::collection(Shuttle::find($id)->ratings);
            return response()->json(['success' => true, 'data' => ['avgRating' => $averageRating, 'showRating' => $rating]], 200);           
        } catch (ModelNotFoundException $e) {            
            return response()->json(['error' => 'Shuttle not found'], 404);
        } catch (Exception $th) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
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
        try {
            Rating::findOrFail($id);
            $rating = new Rating();
            $rating->score = $request->score;
            $rating->comment = $request->comment;
            $rating->user_id = Auth::id();
            $updateResp = Rating::where('id', $id)->update($rating->toArray());
            if ($updateResp) {
                return $this->sendResponse('', 'Updated');
            } else {
                return $this->sendError('Not updated');
            }
        } catch (\Exception $th) {
            return $this->sendError($th->getMessage());
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
        //return $id;
        $rating = Rating::findOrFail($id);
        try {
            $resp = $rating->delete();
            if ($resp) {
                return response()->json(['success' => true, 'message' => 'Deleted'], 200);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }
}
