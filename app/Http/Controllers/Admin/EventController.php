<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::get();
        return view('admin.event.list', [
            'subtitle' => 'All',
            'events' => $events
        ]);
    }

    public function upcoming()
    {
        $events = Event::get();
        return view('admin.event.list', [
            'subtitle' => 'Upcoming',
            'events' => $events
        ]);
    }

    public function featured()
    {
        $events = Event::get();
        return view('admin.event.list', [
            'subtitle' => 'Featured',
            'events' => $events
        ]);
    }

    public function complete()
    {
        $events = Event::get();
        return view('admin.event.list', [
            'subtitle' => 'Complete',
            'events' => $events
        ]);
    }
}
