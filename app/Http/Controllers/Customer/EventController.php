<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFavorite;
use Illuminate\Support\Facades\DB;
use App\Models\ReferralProgram;
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

    public function createRep($id)
    {
        return view('customer.event.affiliate', [
            'id' => $id,
            'title' => 'Create Affiliate',
            'action' => route('customers.event.storeRep')
        ]);
    }

    public function storeRep(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'code' => 'required',
            'referral_fee' => 'required',
            'event_id' => 'required',
        ]);

        $event = Event::where('id', $request->event_id)->firstOrFail();
        $program = ReferralProgram::create([
            'name' => $event->name,
            'uri' => $request->uri
        ]);

        $link = ReferralLink::create([
            'referral_program_id' => $program->id,
            'user_id' => $user_id,
            'code' => $request->code,
            'referral_fee' => $request->referral_fee,
        ]);

        if(!is_null($request->additional_notes)) {
            $link->additional_notes = $request->additional_notes;
        }
        $link->save();
        ReferralRelationship::create([
            'user_id' => $user_id,
            'referral_link_id' => $link->id,
        ]);

        return redirect()->route('customers.event.index')->with('success', 'Event Affiliate created successfully!');
    }

    public function filterCity(Request $request)
    {
        $request->validate([
            'city' => 'required',
        ]);

        $events = DB::table('events')
            ->join('venues', 'venues.id', '=', 'events.venue_id')
            ->where('venues.city', $request->city)
            ->select('events.*')
            ->get();
            
        return view('admin.venue.list', [
            'breadcrumb' => $request->city,
            'events' => $events
        ]);
    }
}
