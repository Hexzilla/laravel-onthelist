<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventDj;
use App\Models\EventGuestlist;
use App\Models\EventMedia;
use App\Models\EventTable;
use App\Models\EventTicket;
use App\Models\User;
use App\Models\Venue;
use App\Models\VenueCity;
use App\Models\Dj;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\EventTicketRule;
use App\Rules\EventTableRule;
use App\Rules\EventGuestRule;
use App\Models\EventMessage;
use Carbon\Carbon;

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
        return json_encode(array('success' => true, 'events' => $events));
    }

    public function create()
    {
        $user_id = Auth::user()->id;
        $venues = Venue::where('user_id', $user_id)->get();
        $djs = Dj::where('vendor_id', $user_id)->get();
        
        return json_encode(array('success' => true, 'venue' => $venues, 'djs' => $djs));
    }

    public function edit($id)
    {
        $user_id = Auth::user()->id;
        
        $venues = Venue::where('user_id', $user_id)->get();
        $event = Event::where('user_id', $user_id)->where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
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
        
        return json_encode(array('success' => true, 'event' => $event, 'venues' => $venues, 'djs' => $djs, 'starts' => $starts, 'ends' => $ends));
    }

    
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
            'type' => ['required', Rule::in(['Public', 'Private'])],
            'venue_id' => 'required|numeric',
            'djs' => 'required|array',
            'start_date' => ['required', 'date_format:Y-m-d'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_date' => ['required', 'date_format:Y-m-d'],
            'end_time' => ['required', 'date_format:H:i'],
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

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }
        $event = new event();
        $event->user_id = $user_id;
        $event->name = $request->name;
        $event->type = $request->type;
        if (!is_null($request->details)) {
            $event->description = $request->details;
        }
        $file = $request->file('header_image');
        $event->header_image_path = $file->store('public/uploads/event');
        $event->start = date('Y-m-d H:i', strtotime($request->start_date . ' ' . $request->start_time));
        $event->end = date('Y-m-d H:i', strtotime($request->end_date . ' ' . $request->end_time));
        $event->venue_id = $request->venue_id;
        $event->is_weekly_event = 0;
        if ($request->is_weekly_event == 'on') {
            $event->is_weekly_event = 1;
        }
        $event->save();
        $djs = $request->djs;

        foreach($djs as $dj){
            $user = Dj::where('id', $dj)->first();
            if (is_null($user)) {
                return json_encode(array('success' => false, 'error' => 'The dj '.$dj.' does not exist.'));
            }
            EventDj::create([
                'event_id' => $event->id,
                'dj_id' => $dj
            ]);
        }

        $this->createMedia($event, $request);
        $this->createTicket($event, $request);
        $this->createTable($event, $request);
        $this->createGuestlist($event, $request);

        return json_encode(array('success' => true));
    }

    public function createMedia($event, $request)
    {
        if ($request->hasFile('gallery_image'))
        {
            $file = $request->file('header_image');
            $event->header_image_path = $file->store('public/uploads/event');
            EventMedia::create([
                'event_id' => $event->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // create media record if the video exists
        if ($request->hasFile('gallery_video'))
        {
            $file = $request->file('header_image');
            $event->header_image_path = $file->store('public/uploads/event');
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

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => ['required', Rule::in(['Public', 'Private'])],
            'venue_id' => 'required|numeric',
            'djs' => 'required',
            'start_date' => ['required', 'date_format:Y-m-d'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_date' => ['required', 'date_format:Y-m-d'],
            'end_time' => ['required', 'date_format:H:i'],
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
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $event = Event::where('user_id', $user_id)->where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event.'));
        }
        $event->name = $request->name;
        $event->type = $request->type;
        if (!is_null($request->details)) {
            $event->description = $request->details;
        }
        if (!is_null($request->file('header_image'))) {
            $file = $request->file('header_image');
            $event->header_image_path = $file->store('public/uploads/event');
        }
        $event->start = date('Y-m-d H:i', strtotime($request->start_date . ' ' . $request->start_time));
        $event->end = date('Y-m-d H:i', strtotime($request->end_date . ' ' . $request->end_time));
        $event->venue_id = $request->venue_id;
        if ($request->is_weekly_event == 'on')
            $event->is_weekly_event = 1;
        $event->save();
        $djs = $request->djs;

        foreach($djs as $dj){
            $user = Dj::where('id', $dj)->first();
            if (is_null($user)) {
                return json_encode(array('success' => false, 'error' => 'The dj '.$dj.' does not exist.'));
            }
            EventDj::where('event_id', $event->id)->delete();
            EventDj::create([
                'event_id' => $event->id,
                'dj_id' => $dj
            ]);
        }

        $this->updateMedia($event, $request);
        $this->updateTicket($event, $request);
        $this->updateTable($event, $request);
        $this->updateGuestlist($event, $request);

        return json_encode(array('success' => true));
    }

    public function updateMedia($event, $request)
    {
        if ($request->hasFile('gallery_image'))
        {
            $file = $request->file('header_image');
            $event->header_image_path = $file->store('public/uploads/event');
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
        $event = Event::where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'The event does not exist'));
        }
        $event->delete();
        return json_encode(array('success' => true));
    }

    public function getTickets($id)
    {
        $event = Event::where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        $tickets = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.event_id', $id)
            ->where('bookings.booking_type', 'Ticket')
            ->select('bookings.*', 'users.name as userName')
            ->get();
        return json_encode(array('success' => true, 'tickets' => $tickets));
    }

    public function getTables($id)
    {
        $event = Event::where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        $tables = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.event_id', $id)
            ->where('bookings.booking_type', 'Table')
            ->select('bookings.*', 'users.name as userName')
            ->get();
        return json_encode(array('success' => true, 'tables' => $tables));
    }

    public function getGuestlists($id)
    {
        $event = Event::where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        $guestlists = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->where('bookings.event_id', $id)
            ->where('bookings.booking_type', 'Guestlist')
            ->select('bookings.*', 'users.name as userName')
            ->get();
        return json_encode(array('success' => true, 'tables' => $guestlists));
    }

    public function showMessage($id)
    {
        $messages = EventMessage::where('event_id', $id)->orderBy('created_at', 'desc')->get();

        return json_encode(array('success' => true, 'messages' => $messages));
    }

    public function markAsRead($id)
    {
        $message = EventMessage::where('id', $id)->first();

        if (is_null($message)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get message'));
        }

        $current = Carbon::now();
        $message->read_at = $current;
        $message->save();

        return json_encode(array('success' => true, 'message' => $message));
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
            
        return json_encode(array('success' => true, 'events' => $events));
    }
}
