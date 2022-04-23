<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFavorite;
use Illuminate\Support\Facades\DB;

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
        
        return json_encode(array('success' => true, 'events' => $events));
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
        return json_encode(array('success' => true, 'events' => $events));
    }

    public function favourited($id)
    {
        $user_id = Auth::user()->id;
        UserFavorite::create([
            'user_id' => $user_id,
            'order_id' => $id,
            'type' => 'event'
        ]);
        return json_encode(array('success' => true));
    }

    public function unfavourite($id)
    {
        $user_id = Auth::user()->id;
        UserFavorite::where('user_id', $user_id)
            ->where('order_id', $id)
            ->where('type', 'event')
            ->delete();
        return json_encode(array('success' => true));
    }

    public function booking($id)
    {
        $event = Event::where('id', $id)->firstOrFail();
        return json_encode(array('success' => true, 'event' => $event));
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
        return json_encode(array('success' => true));
    }
}
