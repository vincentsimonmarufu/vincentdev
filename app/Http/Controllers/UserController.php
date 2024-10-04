<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Traits\CountryTrait;

class UserController extends Controller
{
    use CountryTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id','Desc')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

   
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

   
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function verify($id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at = now();
        $user->save();
        return redirect()->route('users.index')->with('status', 'Successfully verified user');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('status', 'Successfully deleted user');
    }

    public function profile()
    {
        $user = User::findOrFail(Auth::id());
        $countries = $this->getCountries();
        return view('users.profile', compact('user', 'countries'));
    }

    public function updateProfile(Request $request)
    {
        //$user = User::findOrFail(Auth::id());
        //return back()->with('status', 'Successfully updated profile');
        // Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            //'phone' => 'nullable|string|max:20',
            //'email' => 'required|email|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            //'address' => 'nullable|string|max:255',
            //'country' => 'nullable|string|max:255',
        ]);

        // Get the authenticated user
        $user = User::findOrFail(Auth::id());

        // Update user details
        $user->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
        ]);

        // Redirect back with success message
        return redirect()->back()->with('status', 'Successfully updated profile');
    }

    public function type($type)
    {
        if ($type == 'property')
        {
            $users = User::join('apartments', 'apartments.user_id', 'users.id')
                ->select('users.*')
                ->distinct()
                ->get();
        }
        else if ($type == 'vehicle')
        {
            $users = User::join('vehicles', 'vehicles.user_id', 'users.id')
                ->select('users.*')
                ->distinct()
                ->get();
        }
        else if ($type == 'bus')
        {
            $users = User::join('buses', 'buses.user_id', 'users.id')
                ->select('users.*')
                ->distinct()
                ->get();
        }
        else if ($type == 'shuttle')
        {
            $users = User::join('shuttles', 'shuttles.user_id', 'users.id')
                ->select('users.*')
                ->distinct()
                ->get();
        }
        else
        {
            return back()->withErrors('Unsupported user type');
        }

        return view('users.type', compact('users', 'type'));
    }
}
