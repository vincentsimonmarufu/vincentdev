<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Apartment;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApartmentResource;
use App\Http\Resources\VehicleResource;

class CommonApiController extends ResponseController
{
    /**
     * Contact US APi
     */
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:500'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        // $contact = array(
        //     'name' => $name, 'email' => $email,
        //     'subject' => $subject, 'message' => $message
        // );
        $contact = new ContactUs();
        $contact->name = $name;
        $contact->email = $email;
        $contact->subject = $subject;
        $contact->message = $message;

        $contactResp = $contact->save();
        if ($contactResp) {
            return $this->sendResponse('', 'Message accepted');
        } else {
            return $this->sendError('Error');
        }
    }
    /**
     * Search functionality
     * 
     */
    public function search(Request $request)
    {
        //return $request->all();
        $validator = Validator::make($request->all(), [
            'keyword' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            //return $this->sendError($validator->errors(), '', 422);
            return response()->json(['success' => false, 'message' => $validator->errors()], 500);
        }

        $type = $request->type;
        $keyword = $request->keyword;
        if (strtolower($type) == 'vehicle') {
            //check if therre is any vehicle
            // $results = Vehicle::Where('city', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('country', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('transmission', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('fuel_type', 'LIKE', "%{$keyword}%")
            //     ->orWhere('address', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('make', 'LIKE', "%{$keyword}%")
            //     ->orWhere('model', 'LIKE', "%{$keyword}%")
            //     ->orWhere('engine_size', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('price', 'LIKE', "%{$keyword}%")
            //     ->orWhere('year', 'LIKE', "%{$keyword}%")
            //     ->orWhere('name', 'LIKE', "%{$keyword}%")
            //     ->where('status', 'active')->orderBy('id', 'Desc')->get();
                 $results = Vehicle::Where('city', 'LIKE',  "%{$keyword}%")
                ->orWhere('country', 'LIKE',  "%{$keyword}%")
                ->where('status', 'active')->orderBy('id', 'Desc')->get();
            $vehicleResources = VehicleResource::collection($results);
            //->paginate(9);
            if ($vehicleResources) {
                //return $this->sendResponse($vehicleResources, 'Vehicle details');
                return response()->json(['success' => true, 'data' => $vehicleResources, 'message' => 'Apartment list'], 200);
            } else {
                //return $this->sendError('Not found');
                return response()->json(['success' => false, 'message' => 'Not found'], 404);
            }
        }
        if (strtolower($type) == 'flight') {
            //return $this->sendResponse('', 'Redirect to user to flight request form');
            return response()->json(['success' => true, 'message' => 'Redirect to user to flight request form'], 200);
        }
        if (strtolower($type) == 'apartment') {
            //check if therre is any apartment
            // $results = Apartment::Where('city', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('address', 'LIKE', "%{$keyword}%")
            //     ->orWhere('country', 'LIKE',  "%{$keyword}%")
            //     ->orWhere('price', 'LIKE', "%{$keyword}%")
            //     ->orWhere('name', 'LIKE', "%{$keyword}%")
            //     ->where('status', 'active')->orderBy('id', 'Desc')->get();
                  $results = Apartment::Where('city', 'LIKE',  "%{$keyword}%")
                ->orWhere('country', 'LIKE',  "%{$keyword}%")
                ->where('status', 'active')->orderBy('id', 'Desc')->get();
            $apartmentResources = ApartmentResource::collection($results);
            //->paginate(9);
            if ($apartmentResources) {
                //return $this->sendResponse($apartmentResources, 'Apartment details');
                return response()->json(['success' => true, 'data' => $apartmentResources, 'message' => 'Apartment details'], 200);
            } else {
                //return $this->sendError('Not found');
                return response()->json(['success' => false, 'message' => 'Not found'], 404);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Not found'], 404);
        }
    }
}
