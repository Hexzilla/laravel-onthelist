<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::get();
        return view('admin.venue.list', [
            'breadcrumb' => 'All',
            'venues' => $venues
        ]);
    }

    public function featured()
    {
        $venues = Venue::get();
        return view('admin.venue.list', [
            'breadcrumb' => 'Featured',
            'venues' => $venues
        ]);
    }
}
