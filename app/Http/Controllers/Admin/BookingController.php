<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::paginate(10);
        return view('admin.booking.index', ['bookings' => $bookings]);
    }

    public function approve($id)
    {
        $booking = Booking::where('id', $id)->first();
        $booking->status = "Approved";
        $booking->save();
        return redirect()->route('admin.booking.index');
    }

    public function reject($id)
    {
        $booking = Booking::where('id', $id)->first();
        $booking->status = "Rejected";
        $booking->save();
        return redirect()->route('admin.booking.index');
    }
}
