<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venue;
use App\Models\UserFavorite;
use App\Models\VenueBooking;
use App\Models\VenueCity;

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
        return view('customer.venue.list', [
            'breadcrumb' => 'All',
            'venues' => $venues
        ]);
    }

    public function favourite()
    {
        $user_id = Auth::user()->id;

        $venue_ids = UserFavorite::where('type', 'venue')->where('user_id', $user_id)->select('order_id')->get();
        $venues = Venue::whereIn('id', $venue_ids)->paginate(10);
        foreach($venues as $venue) {
            $venue->favourite = true;   
        }

        return view('customer.venue.list', [
            'breadcrumb' => 'Favourite',
            'venues' => $venues
        ]);
    }

    public function favourited($id)
    {
        $user_id = Auth::user()->id;
        UserFavorite::create([
            'user_id' => $user_id,
            'order_id' => $id,
            'type' => 'venue'
        ]);
        return redirect()->back();
    }

    public function unfavourite($id)
    {
        $user_id = Auth::user()->id;
        UserFavorite::where('user_id', $user_id)
            ->where('order_id', $id)
            ->where('type', 'venue')
            ->delete();
        return redirect()->back();
    }

    public function booking($id)
    {
        $event = Venue::where('id', $id)->firstOrFail();
        return view('customer.venue.booking', [
            'venue' => $event
        ]);
    }

    public function createBooking(Request $request)
    {
        $user_id = Auth::user()->id;
        VenueBooking::create([
            'user_id' => $user_id,
            'venue_id' => $request->venue_id,
            'booking_type' => $request->booking_type,
            'type' => $request->type,
            'price' => $request->price,
            'date' => $request->date,
            'time' => $request->time,
        ]);
        return redirect()->route('customers.venues.index');
    }

    public function filterCity($id)
    {
        $city = VenueCity::where('id', $id)->first();

        $events = DB::table('events')
            ->join('venues', 'venues.id', '=', 'events.venue_id')
            ->join('venue_cities', 'venue_cities.name', '=', 'venues.city')
            ->where('venue_cities.id', $id)
            ->select('events.*')
            ->get();
            
        return view('admin.venue.list', [
            'breadcrumb' => $city->name,
            'events' => $events
        ]);
    }
}
