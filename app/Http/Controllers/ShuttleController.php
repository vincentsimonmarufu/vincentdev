<?php

namespace App\Http\Controllers;

use App\Models\Shuttle;
use Illuminate\Http\Request;
use App\Notifications\UserMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreShuttle;
use App\Http\Requests\UpdateShuttle;

use App\Traits\PictureTrait;
use App\Traits\CountryTrait;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShuttleController extends Controller
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
        if (Auth::user()->role == 'admin') {
            $shuttles = Shuttle::orderBy('id', 'Desc')->get();
        } else {
            $shuttles = Shuttle::where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get();
        }
        return view('shuttles.index', compact('shuttles'));
        //return 'hi';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return 'asd';
        $countries = $this->getCountries();
        return view('shuttles.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShuttle $request)
    {
        // dd($request);
        //echo 'hello';
        // dd($request->image_data_url);
        /* $base64_str =$request->image;
       $image = base64_decode($base64_str);
       $safeName = Str::random(8).time().'.'.'png';
         Storage::disk('public')->put('images/'.$safeName, $image);
    file_put_contents($file, $image_base64);*/
        $shuttle = new Shuttle;
        $shuttle->name = $request->input('name');
        $shuttle->seater = $request->input('seater');
        $shuttle->address = $request->input('address');
        $shuttle->city = $request->input('city');
        $shuttle->country = $request->input('country');
        $shuttle->make = $request->input('make');
        $shuttle->model = $request->input('model');
        $shuttle->year = $request->input('year');
        $shuttle->engine_size = $request->input('engine_size');
        $shuttle->fuel_type = $request->input('fuel_type');
        $shuttle->weight = $request->input('weight');
        $shuttle->color = $request->input('color');
        $shuttle->transmission = $request->input('transmission');
        $shuttle->price = $request->input('price');
        $shuttle->status = $request->input('status');
        $shuttle->user_id = Auth::id();
        $shuttle->save();
        if ($files = $request->file('pictures')) {
            $this->storePicture('Shuttle', $shuttle->id, $files);
        }

        //send notification
        $msg = 'New shuttle has been added, to view the view, please click on the button below.';
        $link =  route('shuttles.edit', $shuttle->id);
        $details = [
            'subject' => 'New shuttle added',
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
        $parameters = ['New shuttle added :  ' . $shuttle->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);

        return redirect()->route('shuttles.index')->with('status', 'Successfully added shuttle');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shuttle = Shuttle::findOrFail($id);
        $averageRating = $shuttle->ratings->average('score');
        return view('shuttles.show', compact('shuttle', 'averageRating'));
    }

    public function activate($id)
    {
        $shuttle = Shuttle::findOrFail($id);
        $shuttle->status = 'active';
        $shuttle->save();
        //send notification
        $msg = 'New shuttle has been activated, to view the view, please click on the button below.';
        $link =  route('shuttles.edit', $shuttle->id);
        $details = [
            'subject' => 'New shuttle activated',
            'message' => $msg,
            'actionURL' => $link
        ];
        $users = User::find($shuttle->user_id);
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New shuttle activated :  ' . $shuttle->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);
        return redirect()->route('shuttles.index')->with('status', 'Successfully activated shuttle');
    }
    public function edit($id)
    {
        $shuttle = Shuttle::findOrFail($id);
        $countries = $this->getCountries();
        return view('shuttles.edit', compact('shuttle', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Updateshuttle $request, $id)
    {
        $shuttle = Shuttle::findOrFail($id);
        $shuttle->name = $request->input('name');
        $shuttle->seater = $request->input('seater');
        $shuttle->address = $request->input('address');
        $shuttle->city = $request->input('city');
        $shuttle->country = $request->input('country');
        $shuttle->make = $request->input('make');
        $shuttle->model = $request->input('model');
        $shuttle->year = $request->input('year');
        $shuttle->engine_size = $request->input('engine_size');
        $shuttle->fuel_type = $request->input('fuel_type');
        $shuttle->weight = $request->input('weight');
        $shuttle->color = $request->input('color');
        $shuttle->transmission = $request->input('transmission');
        $shuttle->price = $request->input('price');
        $shuttle->status = $request->input('status');
        // $shuttle->user_id = Auth::id();
        $shuttle->save();

        //send notification
        $msg = 'New shuttle has been updated, to view the view, please click on the button below.';
        $link =  route('shuttles.edit', $shuttle->id);
        $details = [
            'subject' => 'New shuttle updated',
            'message' => $msg,
            'actionURL' => $link
        ];
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New shuttle updated :  ' . $shuttle->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);
        return redirect()->route('shuttles.index')->with('status', 'Successfully updated shuttle');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shuttle = Shuttle::with(['pictures', 'ratings'])->findOrFail($id);
        if ($shuttle->pictures->count() > 0) {
            $this->destroyPictures($shuttle->pictures, 'shuttle');
        }
        if ($shuttle->ratings->count() > 0) {
            foreach ($shuttle->ratings as $rating) {
                $rating->delete();
            }
        }
        $shuttle->delete();

        return redirect()->route('shuttles.index')->with('status', 'Successfully deleted shuttle');
    }
    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        $shuttle = Shuttle::findOrFail($request->input('id'));
        $shuttle->status = $request->input('status');
        $shuttle->user_id = Auth::id();
        $shuttle->save();
        if ($shuttle->status == 'active') {
            //send notification

        }

        return redirect()->route('shuttles.index')->with('status', 'Successfully updated shuttle');
    }
}
