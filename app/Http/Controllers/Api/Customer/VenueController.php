<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venue;
use App\Models\UserFavorite;
use App\Models\VenueBooking;
use Illuminate\Support\Facades\Validator;

class VenueController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $venues = Venue::where('status', 'Approved')->paginate(10);
        foreach($venues as $venue) {
            $favourite = UserFavorite::where('order_id', $venue->id)
                ->where('user_id', $user_id)->where('type', 'venue')->get();
            if (count($favourite) > 0) {
                $venue->favourite = true;
            } else {
                $venue->favourite = false;
            }
        }
        return json_encode(array('success' => true, 'venues' => $venues));
    }

    public function favourite()
    {
        $user_id = Auth::user()->id;

        $venue_ids = UserFavorite::where('type', 'venue')->where('user_id', $user_id)->select('order_id')->get();
        $venues = Venue::whereIn('id', $venue_ids)->paginate(10);
        foreach($venues as $venue) {
            $venue->favourite = true;   
        }

        return json_encode(array('success' => true, 'venues' => $venues));
    }

    public function favourited($id)
    {
        $user_id = Auth::user()->id;
        UserFavorite::create([
            'user_id' => $user_id,
            'order_id' => $id,
            'type' => 'venue'
        ]);
        return json_encode(array('success' => true));
    }

    public function unfavourite($id)
    {
        $user_id = Auth::user()->id;
        UserFavorite::where('user_id', $user_id)
            ->where('order_id', $id)
            ->where('type', 'venue')
            ->delete();
        return json_encode(array('success' => true));
    }

    public function booking($id)
    {
        $venue = Venue::where('id', $id)->first();
        if (is_null($venue)) {
            return json_encode(array('success' => false, 'venue' => $venue));
        }
        return json_encode(array('success' => true, 'venue' => $venue));
    }

    public function createBooking(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'venue_id' => 'required',
            'booking_type' => 'required',
            'type' => 'required',
            'price' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        VenueBooking::create([
            'user_id' => $user_id,
            'venue_id' => $request->venue_id,
            'booking_type' => $request->booking_type,
            'type' => $request->type,
            'price' => $request->price,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return json_encode(array('success' => true));
    }
}
