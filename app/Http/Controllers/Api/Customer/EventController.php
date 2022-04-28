<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFavorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $events = Event::where('status', 'Approved')->paginate(10);
        $events = DB::table('events')
            ->select('events.*', 'user_favorites.id as favourite')
            ->leftJoin('user_favorites', function ($join) {
                $join->on('user_favorites.order_id', '=', 'events.id')
                    ->on('user_favorites.user_id', '=', 'events.user_id')
                    ->where('user_favorites.type', '=', 'event');
            })
            ->where('status', 'Approved')
            ->paginate(10);

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

        return json_encode(array('success' => true, 'events' => $events));
    }

    public function favourited($id)
    {
        $user_id = Auth::user()->id;
        $event = Event::where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
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
        $event = Event::where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        $favourite = UserFavorite::where('user_id', $user_id)
            ->where('order_id', $id)
            ->where('type', 'event')->first();
        if(is_null($favourite)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get favourite event'));
        }
        $favourite->delete();
        return json_encode(array('success' => true));
    }

    public function booking($id)
    {
        $event = Event::where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        return json_encode(array('success' => true, 'event' => $event));
    }

    public function createBooking(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
            'booking_type' => ['required', Rule::in(['Ticket', 'Table Booking', 'Guestlist'])],
            'qty' => 'required',
            'type' => ['required', Rule::in(['Standard', 'EarlyBird', 'VIP'])],
            'price' => 'required',
            'date' => ['required', 'date_format:Y-m-d'],
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $event = Event::where('id', $request->event_id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to create booking'));
        }

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
