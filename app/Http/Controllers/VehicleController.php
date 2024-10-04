<?php

namespace App\Http\Controllers;
use App\Notifications\UserMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreVehicle;
use App\Http\Requests\UpdateVehicle;
use Illuminate\Http\Request;

use App\Traits\PictureTrait;
use App\Traits\CountryTrait;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    use PictureTrait;
    use CountryTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'admin'){
            $vehicles = Vehicle::orderBy('id','Desc')->get();
        }else{
            $vehicles = Vehicle::where('user_id',Auth::user()->id)->orderBy('id','Desc')->get();
        }
        return view('vehicles.index', compact('vehicles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->getCountries();
        return view('vehicles.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicle $request)
    {
       // dd($request->image_data_url);
      /* $base64_str =$request->image;
       $image = base64_decode($base64_str);
       $safeName = Str::random(8).time().'.'.'png';
         Storage::disk('public')->put('images/'.$safeName, $image);
    file_put_contents($file, $image_base64);*/
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
        $vehicle->status = $request->input('status');
        $vehicle->user_id = Auth::id();
        $vehicle->save();
        if($files=$request->file('pictures'))
        {
            $this->storePicture('Vehicle', $vehicle->id, $files);
        }

        //send notification
        $msg = 'New Vehicle has been added, to view the view, please click on the button below.';
        $link =  route('vehicles.edit', $vehicle->id);
        $details = [
            'subject'=>'New Vehicle added',
           'message' => $msg,
           'actionURL' => $link
        ];
        //send owner
        //send to owner
        Notification::send(Auth::user(), new UserMail($details));
        //send admin
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New vehicle added :  '.$vehicle->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms',$parameters);

        return redirect()->route('vehicles.index')->with('status', 'Successfully added vehicle');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $averageRating = $vehicle->ratings->average('score');
        return view('vehicles.show', compact('vehicle', 'averageRating'));
    }

    public function activate($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->status = 'active';
        $vehicle->save();
         //send notification
         $msg = 'New Vehicle has been activated, to view the view, please click on the button below.';
         $link =  route('vehicles.edit', $vehicle->id);
         $details = [
             'subject'=>'New Vehicle activated',
            'message' => $msg,
            'actionURL' => $link
         ];
        $users = User::find($vehicle->user_id);
         Notification::send($users, new UserMail($details));
         //send sms
         $parameters = ['New vehicle activated :  '.$vehicle->id];
         $controller = App::make('\App\Http\Controllers\NotificationsController');
         $data = $controller->callAction('sms',$parameters);
        return redirect()->route('vehicles.index')->with('status', 'Successfully activated vehicle');
    }
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $countries = $this->getCountries();
        return view('vehicles.edit', compact('vehicle', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicle $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
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
        $vehicle->status = $request->input('status');
       // $vehicle->user_id = Auth::id();
        $vehicle->save();

        //send notification
        $msg = 'New Vehicle has been updated, to view the view, please click on the button below.';
        $link =  route('vehicles.edit', $vehicle->id);
        $details = [
            'subject'=>'New Vehicle updated',
           'message' => $msg,
           'actionURL' => $link
        ];
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New vehicle updated :  '.$vehicle->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms',$parameters);
        return redirect()->route('vehicles.index')->with('status', 'Successfully updated vehicle');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::with(['pictures', 'ratings'])->findOrFail($id);
        if ($vehicle->pictures->count() > 0)
        {
            $this->destroyPictures($vehicle->pictures, 'Vehicle');
        }
        if ($vehicle->ratings->count() > 0)
        {
            foreach($vehicle->ratings as $rating)
            {
                $rating->delete();
            }
        }
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('status', 'Successfully deleted vehicle');
    }
    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        $vehicle = Vehicle::findOrFail($request->input('id'));
        $vehicle->status = $request->input('status');
        $vehicle->user_id = Auth::id();
        $vehicle->save();
        if ($vehicle->status == 'active')
        {
            //send notification
           
        }

        return redirect()->route('vehicles.index')->with('status', 'Successfully updated vehicle');
    }
}
