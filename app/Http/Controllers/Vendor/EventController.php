<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventDj;
use App\Models\EventGuestlist;
use App\Models\EventMedia;
use App\Models\EventTable;
use App\Models\EventTicket;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $events = Event::where('user_id', $user_id)->get();
        return view('vendor.venue.list', ['events' => $events]);
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $venues = Venue::where('user_id', $user_id)->get();
        $djs = User::where('role', 'dj')->get();
        return view('vendor.event.create', ['venues' => $venues, 'djs' => $djs]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
            'type' => 'required|numeric',
            'venue_id' => 'required|numeric',
            'djs' => 'required'
        ]);

        $event = new event();
        $event->user_id = $user_id;
        $event->name = $request->name;
        $event->type = "Type 1";
        if(!is_null($request->details))
            $event->description = $request->details;
        $event->header_image_path = upload_file($request->file('header_image'), 'event');
        $event->start = date('Y-m-d H:i', strtotime($request->start_date . ' ' . $request->start_time));
        $event->end = date('Y-m-d H:i', strtotime($request->end_date . ' ' . $request->end_time));
        $event->venue_id = $request->venue_id;
        if($request->is_weekly_event == 'on')
            $event->is_weekly_event = 1;
        $event->save();

        $this->createMedia($event, $request);
        $this->createTicket($event, $request);
        $this->createTable($event, $request);
        $this->createGuestlist($event, $request);
        $this->createDjs($event->id, $request->djs);

        return redirect()->route('venue.index');
    }

    public function createMedia($event, $request)
    {
        if($request->hasFile('gallery_image'))
        {
            $path = upload_file($request->file('gallery_image'), 'event');
            EventMedia::create([
                'event_id' => $event->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // create media record if the video exists
        if($request->hasFile('gallery_video'))
        {
            $path = upload_file($request->file('gallery_video'), 'event');
            EventMedia::create([
                'event_id' => $event->id,
                'type' => 'video',
                'path' => $path
            ]);
        }

        if(!is_null($request->video_link))
        {
            EventMedia::create([
                'event_id' => $event->id,
                'type' => 'link',
                'path' => $request->video_link
            ]);
        }
    }

    public function createTicket($event, $request)
    {
        if($request->has('ticket_type'))
        {
            $ticketSize = sizeof($request->get('ticket_type'));
            for($i = 0; $i < $ticketSize; $i++){
                EventTicket::create([
                    'event_id' => $event->id,
                    'type' => $request->ticket_type[$i],
                    'qty' => $request->ticket_qty[$i],
                    'price' => $request->ticket_price[$i],
                    'approval' => $request->ticket_approval[$i],
                    'description' => $request->ticket_description[$i]
                ]);
            }
        }
    }

    public function createTable($event, $request)
    {
        if($request->has('table_type'))
        {
            $tableSize = sizeof($request->get('table_type'));
            for($i = 0; $i < $tableSize; $i++){
                EventTable::create([
                    'event_id' => $event->id,
                    'type' => $request->table_type[$i],
                    'qty' => $request->table_qty[$i],
                    'price' => $request->table_price[$i],
                    'approval' => $request->table_booking_approval[$i],
                    'description' => $request->table_description[$i]
                ]);
            }
        }
    }

    public function createGuestlist($event, $request)
    {
        if($request->has('guestlist_type'))
        {
            $guestlistSize = sizeof($request->get('guestlist_type'));
            for($i = 0; $i < $guestlistSize; $i++){
                EventGuestlist::create([
                    'event_id' => $event->id,
                    'type' => $request->guestlist_type[$i],
                    'qty' => $request->guestlist_qty[$i],
                    'price' => $request->guestlist_price[$i],
                    'approval' => $request->guestlist_approval[$i],
                    'description' => $request->guestlist_description[$i]
                ]);
            }
        }
    }

    public function createDjs($event_id, $djs)
    {
        foreach($djs as $dj){
            EventDj::create([
                'event_id' => $event_id,
                'user_id' => $dj
            ]);
        }
    }
}
