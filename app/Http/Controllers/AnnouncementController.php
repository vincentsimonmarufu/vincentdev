<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Traits\MessageTrait;

use App\Notifications\Announcement;

class AnnouncementController extends Controller
{
    use MessageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('announcements.create');
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
            'subject'=>'string|required|max:255',
            'introduction'=>'string|required|max:255',
            'url_text'=>'string|required|max:255',
            'url'=>'string|required|max:255',
            'conclusion'=>'string|required|max:255',
        ]);

        $request->validate([
            'subject' => 'required|string|max:255',
            'introduction' => 'required|string|max:255',
            'url_text' => 'required|string|max:255',
            'url'=>'string|max:255',
            'conclusion' => 'string|max:255'
            ]);

        $subject = $request->input('subject');
        $introduction = $request->input('introduction');
        $url_text = $request->input('url_text');
        $url = $request->input('url');
        $conclusion = $request->input('conclusion');

        $users = User::all();
        
        foreach($users as $user)
        {
            try
            {
                $user->notify(new Announcement($subject, $introduction, $url_text, $url, $conclusion));
            }
            catch(\Exception $e)
            {

            }
        }

        return redirect()->route('home')->with('status', 'Successfully sent announcements');
    }

    public function getSendSMS()
    {
        return view('announcements.sms');
    }

    public function postSendSMS(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:160'
        ]);
        $users = User::all();
        
        foreach($users as $user)
        {
            if ($user->phone != null)
            {
                $this->sendSMS($user->phone, $request->input('body'));
            } 
        }

        return redirect()->route('home')->with('status', 'Successfully sent sms announcements');
    }
}
