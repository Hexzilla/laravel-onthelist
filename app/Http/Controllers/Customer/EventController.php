<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'Approved')->get();
        return view('customer.event.index', [
            'breadcrumb' => 'All',
            'events' => $events
        ]);
    }
}
