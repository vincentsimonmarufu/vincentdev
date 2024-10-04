<?php

namespace App\Http\Controllers;
use App\Models\ITN;

use Illuminate\Http\Request;

class ITNController extends Controller
{
    //
    public function index(){
        $itns = ITN::orderBy('id','Desc')->get();
        return view('payments.itn', compact('itns'));
    }
}
