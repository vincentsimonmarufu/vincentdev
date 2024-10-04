<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CorporateTravel;

class CorporateTravelController extends Controller
{
    //capture corporate form data 
    public function corporateFare(){
        return view('corporatefares');
    }


    public function corporateFareSave(Request $request)
    {
        //return $request->all();
        $request->validate([
            'company' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'budget' => 'required|numeric',
            'trips' => 'required|integer',
            'authorized_person' => 'required|string|max:255',
        ]);

        CorporateTravel::create($request->all());

        return redirect()->route('corporatetravel.create')->with('success', 'Corporate travel request submitted successfully!');
    }
}
