<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MeetingController extends Controller
{
 
    public function index()
    {
       $meetings =  Meeting::get();
       $hour = config('meetConfig.DateTimeValue.Hour');
       $minute = config('meetConfig.DateTimeValue.Minute');
        return view('meetings',compact('meetings','hour','minute'));
    }
   

    public function store(Request $request)
    {
        $this->validate($request,[
            'meeting' => 'required',
        ]);

        // Get the data from the form
        $data = $request->input('meeting');

        // Get the existing array from the session, or create an empty one if it doesn't exist yet
        $my_array = session()->get('my_array', []);

        // Check if the session has expired
        $expiration = session()->get('expiration', null);
        if ($expiration !== null && Carbon::now()->gt($expiration)) {
            // The session has expired, clear the array
            $my_array = [];
        }

        if (!in_array($data, $my_array)) {
            // Add the new data to the array
            $my_array[] = $data;

            // Store the updated array and expiration time back in the session
            session()->put('my_array', $my_array);
            session()->put('expiration', Carbon::now()->addDay());

            // Redirect  to the form page
            return redirect()->route("commandes")->with("success","Thank You For Getting a meeting");
        }else{
            return redirect()->route("commandes")->with("failure","Sorry ! this meeting already in your cart");
        }

    }
    

    public function commandes()
    {
        $meetings = session()->get('my_array', []);
        // dd($meetings);
        $total = config('meetConfig.MeetingPrice')*count($meetings);
        return view('commandes',compact("meetings","total"));
    }

    public function destroy($index)
    {
        $meetings = session()->get('my_array', []);

        // Check if the meeting at the specified index exists
        if (array_key_exists($index, $meetings)) {
            // Remove the meeting at the specified index
            unset($meetings[$index]);

            // Store the updated meetings array back in the session
            session()->put('my_array', $meetings);
        }

        // Redirect back to the view that displays the meetings
        return redirect()->back()->with("success","Meeting successfully removed from the cart!");
    }
}
