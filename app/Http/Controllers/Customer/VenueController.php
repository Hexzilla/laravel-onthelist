<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venue;
use App\Models\UserFavorite;

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
}
