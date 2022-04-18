<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::where('status', 'Approved')->get();
        return view('customer.venue.index', [
            'breadcrumb' => 'All',
            'venues' => $venues
        ]);
    }
}
