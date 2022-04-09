<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $bookings = Booking::where('user_id', $user_id)->get();
        return view('vendor.booking', ['bookings' => $bookings]);
    }

    public function approved($id)
    {
        $booking = Booking::where('id', $id)->first();
        $booking->status = "Approved";
        $booking->save();
        return redirect()->route('vendors.booking.index');
    }
}
