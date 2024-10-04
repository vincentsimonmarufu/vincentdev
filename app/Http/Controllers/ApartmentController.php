<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Notifications\UserMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApartment;
use App\Http\Requests\UpdateApartment;
use App\Traits\PictureTrait;
use App\Traits\CountryTrait;

use App\Models\PropertyType;
use App\Models\Apartment;

class ApartmentController extends Controller
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
            $apartments = Apartment::orderBy('id', 'Desc')->get();
        } else {
            $apartments = Apartment::where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get();
        }
        return view('apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->getCountries();
        $propertyTypes = PropertyType::pluck('name', 'id');
        return view('apartments.create', compact('countries', 'propertyTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartment $request)
    {
        $apartment = new Apartment;
        $apartment->name = $request->name;
        $apartment->address = $request->address;
        $apartment->city = $request->city;
        $apartment->country = $request->country;
        $apartment->guest = $request->guest;
        $apartment->bedroom = $request->bedroom;
        $apartment->bathroom = $request->bathroom;
        $apartment->price = $request->price;
        $apartment->property_type_id = $request->property_type_id;
        $apartment->status = "pending";
        $apartment->user_id = Auth::id();
        $apartment->save();
        if ($files = $request->file('pictures')) {
            $this->storePicture('Apartment', $apartment->id, $files);
        }
        //send notification
        $msg = 'New Apartment has been added, to view the view, please click on the button below.';
        $link =  route('apartments.edit', $apartment->id);
        $details = [
            'subject' => 'New Apartment added',
            'message' => $msg,
            'actionURL' => $link
        ];
        //send to owner
        Notification::send(Auth::user(), new UserMail($details));
        //send to admin
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New apartment added :  ' . $apartment->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);
        return redirect()->route('apartments.index')->with('status', 'Successfully added an apartment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Apartment::with('ratings.user')->findOrFail($id);
        $averageRating = $apartment->ratings->average('score');
        return view('apartments.show', compact('apartment', 'averageRating'));
    }

    public function activate($id)
    {
        $apartment = Apartment::findOrFail($id);
        $apartment->status = 'active';
        $apartment->save();
        //send notification
        $msg = 'New Apartment has been activated, to view the view, please click on the button below.';
        $link =  route('apartments.edit', $apartment->id);
        $details = [
            'subject' => 'New Apartment activated',
            'message' => $msg,
            'actionURL' => $link
        ];
        $users = User::find($apartment->user_id);
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New apartment activated :  ' . $apartment->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);
        return redirect()->route('apartments.index')->with('status', 'Successfully activated apartment');
    }
    public function edit($id)
    {
        $apartment = Apartment::findOrFail($id);
        $countries = $this->getCountries();
        $propertyTypes = PropertyType::pluck('name', 'id');
        return view('apartments.edit', compact('apartment', 'countries', 'propertyTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartment $request, $id)
    {
        $apartment = Apartment::findOrFail($id);
        $apartment->name = $request->name;
        $apartment->address = $request->address;
        $apartment->city = $request->city;
        $apartment->country = $request->country;
        $apartment->guest = $request->guest;
        $apartment->bedroom = $request->bedroom;
        $apartment->bathroom = $request->bathroom;
        $apartment->price = $request->price;
        $apartment->status = $request->status;
        //  $apartment->user_id = Auth::id();
        $apartment->save();
        //send notification
        $msg = 'New Apartment has been updated, to view the view, please click on the button below.';
        $link =  route('apartments.edit', $apartment->id);
        $details = [
            'subject' => 'New Apartment updated',
            'message' => $msg,
            'actionURL' => $link
        ];
        $users = User::where('role', 'admin')->get();
        Notification::send($users, new UserMail($details));
        //send sms
        $parameters = ['New apartment updated :  ' . $apartment->id];
        $controller = App::make('\App\Http\Controllers\NotificationsController');
        $data = $controller->callAction('sms', $parameters);

        return redirect()->route('apartments.index')->with('status', 'Successfully updated apartment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apartment = Apartment::with('pictures')->findOrFail($id);
        if ($apartment->pictures->count() > 0) {
            $this->destroyPictures($apartment->pictures, 'Apartment');
        }
        $apartment->delete();

        return redirect()->route('apartments.index')->with('status', 'Successfully deleted apartment');
    }
}
