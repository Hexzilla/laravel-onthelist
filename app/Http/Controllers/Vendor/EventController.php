<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventDj;
use App\Models\EventGuestlist;
use App\Models\EventMedia;
use App\Models\EventTable;
use App\Models\EventTicket;
use App\Models\Ticket;
use App\Models\VenueCity;
use App\Models\User;
use App\Models\Venue;
use App\Models\Dj;
use App\Models\Booking;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Rules\EventTicketRule;
use App\Rules\EventTableRule;
use App\Rules\EventGuestRule;
use App\Models\AffiliateProgram;
use App\Models\AffiliateLink;

class EventController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $events = Event::where('user_id', $user_id)->get();
        foreach($events as $event) {
            $bookings = Booking::orderBy('created_at', 'DESC')->where('event_id', $event->id)->take(5)->get();
            $event->bookings = $bookings;
        }
        return view('vendor.event.list', ['events' => $events]);
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $venues = Venue::where('user_id', $user_id)->get();
        $djs = Dj::where('vendor_id', $user_id)->get();
        return view('vendor.event.create', [
            'venues' => $venues, 
            'djs' => $djs,
            'event' => NULL,
            'starts' => NULL,
            'ends' => NULL,
            'title' => 'Create Event',
            'action' => route('vendors.event.store')
        ]);
    }

    public function edit($id)
    {
        $user_id = Auth::user()->id;
        
        $venues = Venue::where('user_id', $user_id)->get();
        $event = Event::where('user_id', $user_id)->where('id', $id)->firstOrFail();
        if (is_null($event)) {
            return redirect()->back();
        }
        $djs = Dj::where('vendor_id', $user_id)->get();
        foreach ($djs as $dj) {
            $selected = '';
            foreach($event->djs as $event_dj) {
                if ($event_dj->dj_id == $dj->id) {
                    $selected = 'selected';
                    break;
                }
            }
            $dj->selected = $selected;
        }

        $starts = explode(' ', $event->start);
        $ends = explode(' ', $event->start);
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
            'type' => ['required', Rule::in(['Public', 'Private'])],
            'venue_id' => 'required|numeric',
            'djs' => 'required',
            'ticket_type' => ['required', 'array', Rule::in(['Standard', 'EarlyBird', 'VIP']), new EventTicketRule],
            'ticket_qty' => 'required|array',
            'ticket_price' => 'required|array',
            'ticket_approval' => ['required', 'array', Rule::in(['Yes', 'No'])],
            'ticket_description' => 'required|array',
            'table_type' => ['required', 'array', Rule::in(['Standard', 'EarlyBird', 'VIP']), new EventTableRule],
            'table_qty' => 'required|array',
            'table_price' => 'required|array',
            'table_approval' => ['required', 'array', Rule::in(['Yes', 'No'])],
            'table_description' => 'required|array',
            'guestlist_type' => ['required', 'array', Rule::in(['Standard', 'EarlyBird', 'VIP']), new EventGuestRule],
            'guestlist_qty' => 'required|array',
            'guestlist_price' => 'required|array',
            'guestlist_approval' => ['required', 'array', Rule::in(['Yes', 'No'])],
            'guestlist_description' => 'required|array',
        ]);

        $event = new event();
        $event->user_id = $user_id;
        $event->name = $request->name;
        $event->type = $request->type;
        if (!is_null($request->details)) {
            $event->description = $request->details;
        }
        $event->header_image_path = upload_file($request->file('header_image'), 'event');
        $event->start = date('Y-m-d H:i', strtotime($request->start_date . ' ' . $request->start_time));
        $event->end = date('Y-m-d H:i', strtotime($request->end_date . ' ' . $request->end_time));
        $event->venue_id = $request->venue_id;
        $event->is_weekly_event = 0;
        if ($request->is_weekly_event == 'on') {
            $event->is_weekly_event = 1;
        }
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
        if ($request->hasFile('gallery_image'))
        {
            $path = upload_file($request->file('gallery_image'), 'event');
            EventMedia::create([
                'event_id' => $event->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // create media record if the video exists
        if ($request->hasFile('gallery_video'))
        {
            $path = upload_file($request->file('gallery_video'), 'event');
            EventMedia::create([
                'event_id' => $event->id,
                'type' => 'video',
                'path' => $path
            ]);
        }

        if (!is_null($request->video_link))
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
        if ($request->has('ticket_type'))
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
        if ($request->has('table_type'))
        {
            $tableSize = sizeof($request->get('table_type'));
            for($i = 0; $i < $tableSize; $i++){
                EventTable::create([
                    'event_id' => $event->id,
                    'type' => $request->table_type[$i] ?? 'Standard',
                    'qty' => $request->table_qty[$i] ?? 0,
                    'price' => $request->table_price[$i] ?? 0,
                    'approval' => $request->table_approval[$i] ?? 'No',
                    'description' => $request->table_description[$i]
                ]);
            }
        }
    }

    public function createGuestlist($event, $request)
    {
        if ($request->has('guestlist_type'))
        {
            $guestlistSize = sizeof($request->get('guestlist_type'));
            for($i = 0; $i < $guestlistSize; $i++){
                EventGuestlist::create([
                    'event_id' => $event->id,
                    'type' => $request->guestlist_type[$i] ?? 'Standard',
                    'qty' => $request->guestlist_qty[$i] ?? 0,
                    'price' => $request->guestlist_price[$i] ?? 0,
                    'approval' => $request->guestlist_approval[$i] ?? 'No',
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
                'dj_id' => $dj
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'type' => ['required', Rule::in(['Public', 'Private'])],
            'venue_id' => 'required|numeric',
            'djs' => 'required',
            'ticket_type' => ['required', 'array', Rule::in(['Standard', 'EarlyBird', 'VIP']), new EventTicketRule],
            'ticket_id' => 'required|array',
            'ticket_qty' => 'required|array',
            'ticket_price' => 'required|array',
            'ticket_approval' => ['required', 'array', Rule::in(['Yes', 'No'])],
            'ticket_description' => 'required|array',
            'table_type' => ['required', 'array', Rule::in(['Standard', 'EarlyBird', 'VIP']), new EventTableRule],
            'table_id' => 'required|array',
            'table_qty' => 'required|array',
            'table_price' => 'required|array',
            'table_approval' => ['required', 'array', Rule::in(['Yes', 'No'])],
            'table_description' => 'required|array',
            'guestlist_type' => ['required', 'array', Rule::in(['Standard', 'EarlyBird', 'VIP']), new EventGuestRule],
            'guestlist_id' => 'required|array',
            'guestlist_qty' => 'required|array',
            'guestlist_price' => 'required|array',
            'guestlist_approval' => ['required', 'array', Rule::in(['Yes', 'No'])],
            'guestlist_description' => 'required|array',
        ]);

        $events = Event::where('user_id', $user_id)->where('id', $id)->get();
        $event = $events[0];
        $event->name = $request->name;
        $event->type = $request->type;
        if (!is_null($request->details)) {
            $event->description = $request->details;
        }
        if (!is_null($request->file('header_image'))) {
            $event->header_image_path = upload_file($request->file('header_image'), 'event');
        }
        $event->start = date('Y-m-d H:i', strtotime($request->start_date . ' ' . $request->start_time));
        $event->end = date('Y-m-d H:i', strtotime($request->end_date . ' ' . $request->end_time));
        $event->venue_id = $request->venue_id;
        if ($request->is_weekly_event == 'on')
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
        if ($request->hasFile('gallery_image'))
        {
            $path = upload_file($request->file('gallery_image'), 'event');
            EventMedia::create([
                'event_id' => $event->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        if (!is_null($request->video_link))
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
        if ($request->has('ticket_type'))
        {
            $ticketIds = $request->get('ticket_id');
            $ticketIds = array_filter($ticketIds, function($id) {
                return isset($id);
            });
            if (count($ticketIds) > 0) {
                EventTicket::where('event_id', $event->id)->whereNotIn('id', $ticketIds)->delete();
            } else {
                EventTicket::where('event_id', $event->id)->delete();
            }
           
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
            $tableIds = $request->get('table_id');
            $tableIds = array_filter($tableIds, function($id) {
                return isset($id);
            });
            if (count($tableIds) > 0) {
                EventTable::where('event_id', $event->id)->whereNotIn('id', $tableIds)->delete();
            } else {
                EventTable::where('event_id', $event->id)->delete();
            }

            $tableSize = sizeof($request->get('table_type'));
            $tables = array();
            for($i = 0; $i < $tableSize; $i++) {
                array_push($tables, [
                    'id' =>  $request->table_id[$i],
                    'event_id' => $event->id,
                    'type' =>  $request->table_type[$i] ?? 'Standard',
                    'qty' =>  $request->table_qty[$i] ?? 0,
                    'price' =>  $request->table_price[$i] ?? 0,
                    'approval' =>  $request->table_approval[$i] ?? 'No',
                    'description' =>  $request->table_description[$i],
                ]);
            }
            EventTable::upsert($tables, ['id'], ['type', 'qty', 'price', 'approval', 'description']);
        }
    }

    public function updateGuestlist($event, $request)
    {
        if ($request->has('guestlist_type'))
        {
            $guestIds = $request->get('guestlist_id');
            $guestIds = array_filter($guestIds, function($id) {
                return isset($id);
            });
            if (count($guestIds) > 0) {
                EventGuestlist::where('event_id', $event->id)->whereNotIn('id', $guestIds)->delete();
            } else {
                EventGuestlist::where('event_id', $event->id)->delete();
            }
            
            $guestlistSize = sizeof($request->get('guestlist_type'));
            $guestlists = array();
            for($i = 0; $i < $guestlistSize; $i++) {
                array_push($guestlists, [
                    'id' =>  $request->guestlist_id[$i],
                    'event_id' => $event->id,
                    'type' =>  $request->guestlist_type[$i] ?? 'Standard',
                    'qty' =>  $request->guestlist_qty[$i] ?? 0,
                    'price' =>  $request->guestlist_price[$i] ?? 0,
                    'approval' =>  $request->guestlist_approval[$i] ?? 'No',
                    'description' =>  $request->guestlist_description[$i],
                ]);
            }
            EventGuestlist::upsert($guestlists, ['id'], ['type', 'qty', 'price', 'approval', 'description']);
        }
    }

    public function updateDjs($event_id, $djs)
    {
        EventDj::where('event_id', $event_id)->delete();
        foreach($djs as $dj){
            EventDj::create([
                'event_id' => $event_id,
                'dj_id' => $dj
            ]);
        }
    }

    public function destroy($id)
    {
        Event::where('id', $id)->delete();
        return redirect()->route('vendors.event.index');
    }

    public function getTickets($id)
    {
        $tickets = DB::table('bookings')
            ->join('tickets', 'bookings.id', '=', 'tickets.member_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.event_id', $id)
            ->where('bookings.booking_type', 'Ticket')
            ->where('tickets.type', 'event')
            ->select('bookings.*', 'users.name as userName', 'tickets.is_scanned')
            ->get();
        return json_encode(array('data' => $tickets));
    }

    public function getTables($id)
    {
        $tables = DB::table('bookings')
            ->join('tickets', 'bookings.id', '=', 'tickets.member_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.event_id', $id)
            ->where('bookings.booking_type', 'Table')
            ->where('tickets.type', 'event')
            ->select('bookings.*', 'users.name as userName', 'tickets.is_scanned')
            ->get();
        return json_encode(array('data' => $tables));
    }

    public function getGuestlists($id)
    {
        $guestlists = DB::table('bookings')
            ->join('tickets', 'bookings.id', '=', 'tickets.member_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.event_id', $id)
            ->where('bookings.booking_type', 'Guestlist')
            ->where('tickets.type', 'event')
            ->select('bookings.*', 'users.name as userName', 'tickets.is_scanned')
            ->get();
        return json_encode(array('data' => $guestlists));
    }

    public function createRep($id)
    {
        $programs = AffiliateProgram::get();
        return view('vendor.event.affiliate', [
            'programs' => $programs,
            'title' => 'Create Affiliate',
            'action' => route('vendors.event.storeRep', $id)
        ]);
    }

    public function storeRep(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'program_id' => 'required',
            'name' => 'required',
        ]);

        $program = AffiliateProgram::where('id', $request->program_id)->first();
        $code = $program->code;
        $url = route('customers.events.booking', $id);
        $uri = $url.'?'.$code;

        AffiliateLink::create([
            'event_id' => $id,
            'program_id' => $request->program_id,
            'name' => $request->name,
            'uri' => $uri,
        ]);

        return redirect()->route('vendors.event.index')->with('success', 'Event Affiliate created successfully!');
    }

    public function filterCity($id)
    {
        $user_id = Auth::user()->id;
        $city = VenueCity::where('id', $id)->first();
        $events = DB::table('events')
            ->join('venues', 'venues.id', '=', 'events.venue_id')
            ->join('venue_cities', 'venue_cities.name', '=', 'venues.city')
            ->where('venue_cities.id', $id)
            ->where('events.user_id', $user_id)
            ->select('events.*')
            ->get();
            
        return view('admin.venue.list', [
            'breadcrumb' => $city->name,
            'events' => $events
        ]);
    }

    public function reps()
    {
        $reps = DB::table('reps_stats')
            ->join('affiliate_links', 'affiliate_links.id', '=', 'reps_stats.affiliate_link_id')
            ->join('affiliate_programs', 'affiliate_programs.id', '=', 'affiliate_links.affiliate_program_id')
            ->select('affiliate_programs.referral_fee as fee', 'affiliate_links.name as name', 'reps_stats.qty as qty', 'reps_stats.price as price')
            ->get();
        
        return view('vendor.event.reps', [
            'reps' => $reps,
        ]);
    }

    public function scanBooking(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'booking_id' => 'required',
        ]);

        $ticket = Ticket::where('member_id', $request->booking_id)->first();
        if ($ticket) {
            $ticket->is_scanned = 1;
            $ticket->save();
            return redirect()->route('vendors.event.index')->with('success', 'Scan Booking Success');
        } else {
            return redirect()->route('vendors.event.index')->with('error', 'Invalid Booking ID');
        }
    }
}
