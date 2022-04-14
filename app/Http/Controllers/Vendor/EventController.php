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
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $events = Event::where('user_id', $user_id)->get();
        foreach($events as $event)
        {
            $bookings = Booking::orderBy('created_at', 'DESC')->where('event_id', $event->id)->take(5)->get();
            $event->bookings = $bookings;
        }
        return view('vendor.event.list', ['events' => $events]);
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $venues = Venue::where('user_id', $user_id)->get();
        $djs = User::where('role', 'dj')->get();
        return view('vendor.event.create', [
            'venues' => $venues, 
            'djs' => $djs,
            'event' => null,
            'starts' => null,
            'ends' => null,
            'title' => 'Create Event',
            'action' => route('vendors.event.store')
        ]);
    }

    public function edit($id)
    {
        $user_id = Auth::user()->id;
        $djs = User::where('role', 'dj')->get();
        $venues = Venue::where('user_id', $user_id)->get();
        $event = Event::where('user_id', $user_id)->where('id', $id)->firstOrFail();
        if(is_null($event)) {
            return redirect()->back();
        }
        $starts = explode(' ', $event->start);
        $ends = explode(' ', $event->start);

        foreach($djs as $dj) {
            $selected = '';
            foreach($event->djs as $event_dj) {
                if ($event_dj->user_id == $dj->id) {
                    $selected = 'selected';
                    break;
                }
            }
            $dj->selected = $selected;
        }

        return view('vendor.event.create', [
            'event' => $event, 
            'venues' => $venues, 
            'djs' => $djs,
            'title' => 'Edit Event',
            'action' => route('vendors.event.update', $id),
            'starts' => $starts,
            'ends' => $ends,
        ]);
    }

    
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
            'type' => 'required',
            'venue_id' => 'required|numeric',
            'djs' => 'required'
        ]);

        $event = new event();
        $event->user_id = $user_id;
        $event->name = $request->name;
        $event->type = $request->type;
        if(!is_null($request->details))
            $event->description = $request->details;
        $event->header_image_path = upload_file($request->file('header_image'), 'event');
        $event->start = date('Y-m-d H:i', strtotime($request->start_date . ' ' . $request->start_time));
        $event->end = date('Y-m-d H:i', strtotime($request->end_date . ' ' . $request->end_time));
        $event->venue_id = $request->venue_id;
        $event->is_weekly_event = 0;
        if($request->is_weekly_event == 'on')
            $event->is_weekly_event = 1;
        $event->save();

        $this->createMedia($event, $request);
        $this->createTicket($event, $request);
        $this->createTable($event, $request);
        $this->createGuestlist($event, $request);
        $this->createDjs($event->id, $request->djs);

        return redirect()->route('vendors.event.index');
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
                    'type' => $request->ticket_type[$i] ?? 'Standard',
                    'qty' => $request->ticket_qty[$i] ?? 0,
                    'price' => $request->ticket_price[$i] ?? 0,
                    'approval' => $request->ticket_approval[$i] ?? 'No',
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
                    'type' => $request->table_type[$i] ?? 'Standard',
                    'qty' => $request->table_qty[$i] ?? 0,
                    'price' => $request->table_price[$i] ?? 0,
                    'approval' => $request->table_booking_approval[$i] ?? 'No',
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
                    'type' => $request->guestlist_type[$i] ?? 'Standard',
                    'qty' => $request->guestlist_qty[$i] ?? 0,
                    'price' => $request->guestlist_price[$i] ?? 0,
                    'approval' => $request->guestlist_booking_approval[$i] ?? 'No',
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

    

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'venue_id' => 'required|numeric',
            'djs' => 'required'
        ]);

        $events = Event::where('user_id', $user_id)->where('id', $id)->get();
        $event = $events[0];
        $event->name = $request->name;
        $event->type = $request->type;
        if(!is_null($request->details))
            $event->description = $request->details;
        if(!is_null($request->file('header_image'))) {
            $event->header_image_path = upload_file($request->file('header_image'), 'event');
        }
        $event->start = date('Y-m-d H:i', strtotime($request->start_date . ' ' . $request->start_time));
        $event->end = date('Y-m-d H:i', strtotime($request->end_date . ' ' . $request->end_time));
        $event->venue_id = $request->venue_id;
        if($request->is_weekly_event == 'on')
            $event->is_weekly_event = 1;
        $event->save();

        $this->updateMedia($event, $request);
        $this->updateTicket($event, $request);
        $this->updateTable($event, $request);
        $this->updateGuestlist($event, $request);
        $this->updateDjs($event->id, $request->djs);

        return redirect()->route('vendors.event.index');
    }

    public function updateMedia($event, $request)
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

        if(!is_null($request->video_link))
        {
            EventMedia::create([
                'event_id' => $event->id,
                'type' => 'link',
                'path' => $request->video_link
            ]);
        }
    }

    public function updateTicket($event, $request)
    {
        if($request->has('ticket_type'))
        {
            $ticketSize = sizeof($request->get('ticket_type'));
            $tickets = array();
            for($i = 0; $i < $ticketSize; $i++){
                array_push($tickets, [
                    'id' =>  $request->ticket_id[$i],
                    'event_id' => $event->id,
                    'type' => $request->ticket_type[$i] ?? 'Standard',
                    'qty' => $request->ticket_qty[$i] ?? 0,
                    'price' => $request->ticket_price[$i] ?? 0,
                    'approval' => $request->ticket_approval[$i] ?? 'No',
                    'description' => $request->ticket_description[$i]
                ]);       
            }
            EventTicket::upsert($tickets, ['id'], ['type', 'qty', 'price', 'approval', 'description']);
        }
    }

    public function updateTable($event, $request)
    {
        if ($request->has('table_type'))
        {
            $tableSize = sizeof($request->get('table_type'));
            $tables = array();
            for($i = 0; $i < $tableSize; $i++) {
                array_push($tables, [
                    'id' =>  $request->table_id[$i],
                    'event_id' => $event->id,
                    'type' =>  $request->table_type[$i] ?? 'Standard',
                    'qty' =>  $request->table_qty[$i] ?? 0,
                    'price' =>  $request->table_price[$i] ?? 0,
                    'approval' =>  $request->table_booking_approval[$i] ?? 'No',
                    'description' =>  $request->table_description[$i],
                ]);
            }
            EventTable::upsert($tables, ['id'], ['type', 'qty', 'price', 'approval', 'description']);
        }
    }

    public function updateGuestlist($event, $request)
    {
        if($request->has('guestlist_type'))
        {
            $guestlistSize = sizeof($request->get('guestlist_type'));
            $guestlists = array();
            for($i = 0; $i < $guestlistSize; $i++) {
                array_push($guestlists, [
                    'id' =>  $request->guestlist_id[$i],
                    'event_id' => $event->id,
                    'type' =>  $request->guestlist_type[$i] ?? 'Standard',
                    'qty' =>  $request->guestlist_qty[$i] ?? 0,
                    'price' =>  $request->guestlist_price[$i] ?? 0,
                    'approval' =>  $request->guestlist_booking_approval[$i] ?? 'No',
                    'description' =>  $request->guestlist_description[$i],
                ]);
            }
            EventGuestlist::upsert($guestlists, ['id'], ['type', 'qty', 'price', 'approval', 'description']);
        }
    }

    public function updateDjs($event_id, $djs)
    {
        $eventdjs = EventDj::where('event_id', $event_id)->get();
        foreach($eventdjs as $eventdj) {
            $eventdj->delete();
        }
        foreach($djs as $dj){
            EventDj::create([
                'event_id' => $event_id,
                'user_id' => $dj
            ]);
        }
    }

    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $event = Event::where('user_id', $user_id)->where('id', $id)->get();
        $event[0] -> delete();
        return redirect()->route('vendors.event.index');
    }
}
