<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use Notification;
use App\Notifications\NewNotification;

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
            ->get();
       
        return view('vendor.booking.index', ['bookings' => $bookings]);
    }

    public function approve($id)
    {
        $booking = Booking::where('id', $id)->first();

        $user = User::where('id', $booking->user_id)->firstOrFail();

        $details = [
            'title' => 'Approve Booking '.$booking->id,
            'description' => 'Vendor approved this booking',
            'order_id' => $booking->id,
            'type' => 'booking',
            'user_id' => $booking->user_id,
        ];

        Notification::send($user, new NewNotification($details));

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
