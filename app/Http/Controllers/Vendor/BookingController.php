<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Notifications\Approved;
use App\Models\User;
use Notification;

class BookingController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $bookings = DB::table('bookings')
            ->join('events', 'events.id', '=', 'bookings.event_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->join('venues', 'venues.id', '=', 'events.venue_id')
            ->where('events.user_id', $user_id)
            ->select('bookings.*', 'events.name as eventName', 'events.type as eventType', 'users.name as userName', 'venues.name as venueName')
            ->paginate(10);
       
        return view('vendor.booking.index', ['bookings' => $bookings]);
    }

    public function approve($id)
    {
        $booking = Booking::where('id', $id)->first();

        $user = User::where('id', $booking->user_id)->firstOrFail();

        $details = [
            'title' => 'Booking Approved',
            'description' => 'Vendor approved your booking ' . $booking->id,
            'type' => 'booking',
            'user_id' => $booking->user_id,
            'item_id' => $booking->id,
        ];
        Notification::send($user, new Approved($details));

        $booking->status = "Approved";
        $booking->save();
        return redirect()->route('vendors.booking.index');
    }

    public function reject($id)
    {
        $booking = Booking::where('id', $id)->first();
        $booking->status = "Rejected";
        $booking->save();
        return redirect()->route('vendors.booking.index');
    }
}
