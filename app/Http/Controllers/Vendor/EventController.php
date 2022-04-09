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
        return view('vendor.event.list', ['events' => $events]);
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
                    'approval' => $request->guestlist_booking_approval[$i],
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

    public function edit($id)
    {
        $user_id = Auth::user()->id;
        $djs = User::where('role', 'dj')->get();
        $venues = Venue::where('user_id', $user_id)->get();
        $events = Event::where('user_id', $user_id)->where('id', $id)->get();
        $event = $events[0];
        return view('vendor.event.edit', ['event' => $event, 'venues' => $venues, 'djs' => $djs]);
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
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
        $event->header_image_path = upload_file($request->file('header_image'), 'event');
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

        return redirect()->route('vendor.event.index');
    }

    public function updateMedia($event, $request)
    {
        $medias = EventMedia::where('event_id', $event->id)->get();
        $size = count($medias);
        
        if($request->hasFile('gallery_image'))
        {
            $path = upload_file($request->file('gallery_image'), 'event');
            if ($size > 0) {
                $media = $medias[0];
                $media->type = 'image';
                $media->path = $path;
                $media->save();
            } else {
                EventMedia::create([
                    'event_id' => $event->id,
                    'type' => 'image',
                    'path' => $path
                ]);
            }
        }

        // update media record if the video exists
        if($request->hasFile('gallery_video'))
        {
            $path = upload_file($request->file('gallery_video'), 'event');            
            if ($size > 0) {
                $media = $medias[0];
                $media->type = 'video';
                $media->path = $path;
                $media->save();
            } else {
                VenueMedia::create([
                    'event_id' => $event->id,
                    'type' => 'video',
                    'path' => $path
                ]);
            }
        }

        if(!is_null($request->video_link))
        {
            if ($size > 0) {
                $media = $medias[0];
                $media->type = 'link';
                $media->path = $request->video_link;
                $media->save();
            } else {
                EventMedia::create([
                    'event_id' => $event->id,
                    'type' => 'link',
                    'path' => $request->video_link
                ]);
            }
        }
    }

    public function updateTicket($event, $request)
    {
        if($request->has('ticket_type'))
        {
            $ticketSize = sizeof($request->get('ticket_type'));
            $tickets = EventTicket::where('event_id', $event->id)->get();
            $size = count($tickets);
            for($i = 0; $i < $ticketSize; $i++){
                if ($size > $i) {
                    $ticket = $tickets[$i];
                    $ticket->type = $request->ticket_type[$i];
                    $ticket->qty = $request->ticket_qty[$i];
                    $ticket->price = $request->ticket_price[$i];
                    $ticket->approval = $request->ticket_approval[$i];
                    $ticket->description = $request->ticket_description[$i];
                } else {
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
    }

    public function updateTable($event, $request)
    {
        if($request->has('table_type'))
        {
            $tableSize = sizeof($request->get('table_type'));
            $tables = EventTable::where('event_id', $event->id)->get();
            $size = count($tables);
            for($i = 0; $i < $tableSize; $i++){
                if ($size > $i) {
                    $table = $tables[$i];
                    $table->type = $request->table_type[$i];
                    $table->qty = $request->table_qty[$i];
                    $table->price = $request->table_price[$i];
                    $table->approval = $request->table_booking_approval[$i];
                    $table->description = $request->table_description[$i];
                    $table->save();
                } else {
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
    }

    public function updateGuestlist($event, $request)
    {
        if($request->has('guestlist_type'))
        {
            $guestlistSize = sizeof($request->get('guestlist_type'));
            $guestlists = EventGuestlist::where('event_id', $event->id)->get();
            $size = count($guestlists);
            for($i = 0; $i < $guestlistSize; $i++){
                if ($size > $i) {
                    $guestlist = $guestlists[$i];
                    $guestlist->type = $request->guestlist_type[$i];
                    $guestlist->qty = $request->guestlist_qty[$i];
                    $guestlist->price = $request->guestlist_price[$i];
                    $guestlist->approval = $request->guestlist_booking_approval[$i];
                    $guestlist->description = $request->guestlist_description[$i];
                    $guestlist->save();
                } else {
                    EventGuestlist::create([
                        'event_id' => $event->id,
                        'type' => $request->guestlist_type[$i],
                        'qty' => $request->guestlist_qty[$i],
                        'price' => $request->guestlist_price[$i],
                        'approval' => $request->guestlist_booking_approval[$i],
                        'description' => $request->guestlist_description[$i]
                    ]);
                }  
            }
        }
    }

    public function updateDjs($event_id, $djs)
    {
        $i = 0;
        foreach($djs as $dj){
            $eventdjs = EventDj::where('event_id', $event_id)->get();
            $eventdj = $eventdjs[$i];
            if (!$eventdj) {
                EventDj::create([
                    'event_id' => $event_id,
                    'user_id' => $dj
                ]);
            } else {
                $eventdj->user_id = $dj;
            }
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
