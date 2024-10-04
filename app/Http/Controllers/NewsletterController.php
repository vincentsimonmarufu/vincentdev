<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Newsletter;
use App\Mail\SendNewsletter;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsletters = Newsletter::orderBy('id', 'Desc')->get();
        return view('newsletters.index', compact('newsletters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newsletters.create');
    }

    public function subscribe(Request $request)
    {
        try {
            $request->validate([
                'fullname' => 'required|string',
                'email' => 'email|required|unique:newsletters'
            ]);
        } catch (ValidationException $e) {
            // Check if the error is due to email uniqueness
            if ($e->errors()['email'][0]) {
                return response()->json(['message' => 'Email already exists'], 400);
            } else {
                // Handle other validation errors
                return response()->json(['message' => $e->getMessage()], 400);
            }
        }

        $newsletter = new Newsletter;
        $newsletter->fullname = $request->fullname;
        $newsletter->email = $request->email;
        $newsletter->save();

        return response()->json(['message' => 'Subscription successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'email|required|unique:newsletters'
        ]);

        $newsletter = new Newsletter;
        $newsletter->email = $request->input('email');
        $newsletter->save();

        return back()->with('status', 'Successfully signed up for newsletter');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return back()->with('status', 'Successfully unsubscribed user');
    }

    public function send(Request $request)
    {
        $message = $request->message;
        $subscribedUsers = Newsletter::all();
        foreach ($subscribedUsers as $subscribedUser) {
            try {
                $user = new User();
                $user->name = 'Customer';
                $user->email = $subscribedUser->email;
                Mail::to($user)->send(new SendNewsletter($message));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('home')->with('status', 'Successfully sent newsletters');
    }
}
