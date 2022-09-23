<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use App\Models\VenueCity;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFavorite;
use Illuminate\Support\Facades\DB;
use App\Models\AffiliateProgram;
use App\Models\ReferralLink;
use App\Models\ReferralRelationship;

class EventController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $events = Event::where('status', 'Approved')->paginate(10);
        foreach($events as $event) {
            $favourite = UserFavorite::where('order_id', $event->id)
                ->where('user_id', $user_id)->where('type', 'event')->get();
            if (count($favourite) > 0) {
                $event->favourite = true;
            } else {
                $event->favourite = false;
            }
        }
        return view('customer.event.list', [
            'breadcrumb' => 'All',
            'events' => $events
        ]);
    }

    public function favourite()
    {
        $user_id = Auth::user()->id;

        $event_ids = UserFavorite::where('type', 'event')->where('user_id', $user_id)->select('order_id')->get();
        $events = Event::whereIn('id', $event_ids)->paginate(10);
        foreach($events as $event) {
            $event->favourite = true;   
        }

        return view('customer.event.list', [
            'breadcrumb' => 'Favourite',
            'events' => $events
        ]);
    }

    public function favourited($id)
    {
        $user_id = Auth::user()->id;
        UserFavorite::create([
            'user_id' => $user_id,
            'order_id' => $id,
            'type' => 'event'
        ]);
        return redirect()->back();
    }

    public function unfavourite($id)
    {
        $user_id = Auth::user()->id;
        UserFavorite::where('user_id', $user_id)
            ->where('order_id', $id)
            ->where('type', 'event')
            ->delete();
        return redirect()->back();
    }

    public function booking($id)
    {
        $event = Event::where('id', $id)->firstOrFail();
        return view('customer.event.booking', [
            'event' => $event
        ]);
    }

    public function createBooking(Request $request)
    {
        $user_id = Auth::user()->id;
        Booking::create([
            'user_id' => $user_id,
            'event_id' => $request->event_id,
            'booking_type' => $request->booking_type,
            'qty' => $request->qty,
            'type' => $request->type,
            'price' => $request->price,
            'date' => $request->date,
        ]);
        return redirect()->route('customers.events.index');
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

    public function rep()
    {
        $user_id = Auth::user()->id;
        $rep = AffiliateProgram::where('user_id', $user_id)->first();
        return view('customer.rep', [
            'rep' => $rep,
            'title' => 'Create Affiliate Program',
            'action' => route('customers.events.storeRep')
        ]);
    }

    public function storeRep(Request $request)
    {
        $user_id = Auth::user()->id;
        $rep = AffiliateProgram::where('user_id', $user_id)->first();
        $request->validate([
            'code' => 'required|unique:affiliate_programs',
            'referral_fee' => 'required'
        ]);
        if (!is_null($rep)) {
            $rep->code = $request->code;
            $rep->referral_fee = $request->referral_fee;
        } else {
            $rep = AffiliateProgram::create([
                'user_id' => $user_id,
                'code' => $request->code,
                'referral_fee' => $request->referral_fee
            ]);
        }

        if (!is_null($request->additional_note)) {
            $rep->additional_note = $request->additional_note;
        }
        $rep->save();

        return redirect()->route('customers.dashboard');
    }
}
