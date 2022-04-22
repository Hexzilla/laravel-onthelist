<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventDj;
use App\Models\EventGuestlist;
use App\Models\EventMedia;
use App\Models\EventTable;
use App\Models\EventTicket;
use App\Models\User;
use App\Models\Dj;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Notification;
use App\Notifications\NewNotification;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::paginate(10);
        return view('admin.event.list', [
            'breadcrumb' => 'All',
            'events' => $events
        ]);
    }

    public function upcoming()
    {
        $current = Carbon::now();
        $events = Event::where('start', '>', $current)->paginate(10);
        return view('admin.event.list', [
            'breadcrumb' => 'Upcoming',
            'events' => $events
        ]);
    }

    public function featured()
    {
        $events = Event::where('feature', 'yes')->paginate(10);
        return view('admin.event.list', [
            'breadcrumb' => 'Featured',
            'events' => $events
        ]);
    }

    public function complete()
    {
        $current = Carbon::now();
        $events = Event::where('end', '<', $current)->paginate(10);
        return view('admin.event.list', [
            'breadcrumb' => 'Complete',
            'events' => $events
        ]);
    }

    public function feature($id)
    {
        $user_id = Auth::user()->id;
        $events  = Event::where('id', $id)->get();
        $event = $events[0];
        $event->feature = "yes";
        $event->save();
        return redirect()->route('admin.events.index');
    }

    public function unfeature($id)
    {
        $user_id = Auth::user()->id;
        $events  = Event::where('id', $id)->get();
        $event = $events[0];
        $event->feature = "no";
        $event->save();
        return redirect()->route('admin.events.index');
    }

    public function approve($id)
    {
        $event = Event::where('id', $id)->firstOrFail();
        if (is_null($event)) {
            return redirect()->back();
        }
        $user = User::where('id', $event->user_id)->firstOrFail();

        $details = [
            'title' => 'Approve Event '.$event->name,
            'description' => 'Admin approved this event',
            'order_id' => $event->id,
            'user_id' => $event->user_id,
            'type' => 'event',
        ];

        Notification::send($user, new NewNotification($details));

        $event->status = 'Approved';
        $event->save();
        return redirect()->back();
    }

    public function reject($id)
    {
        $event = Event::where('id', $id)->firstOrFail();
        $event->status = 'Rejected';
        $event->save();
        return redirect()->back();
    }

    public function edit($id)
    {
        $event = Event::where('id', $id)->firstOrFail();
        $user_id = $event->user_id;
        $djs = Dj::where('vendor_id', $user_id)->get();
        $venues = Venue::where('user_id', $user_id)->get();

        if (is_null($event)) {
            return redirect()->back();
        }
        $starts = explode(' ', $event->start);
        $ends = explode(' ', $event->start);

        foreach($djs as $dj) {
            $selected = '';
            foreach($event->djs as $event_dj) {
                if ($event_dj->dj_id == $dj->id) {
                    $selected = 'selected';
                    break;
                }
            }
            $dj->selected = $selected;
        }

        return view('admin.event.create', [
            'event' => $event, 
            'venues' => $venues, 
            'djs' => $djs,
            'title' => 'Edit Event',
            'action' => route('admin.events.update', $id),
            'starts' => $starts,
            'ends' => $ends,
        ]);
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

        $events = Event::where('id', $id)->get();
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
        if($request->is_weekly_event == 'on')
            $event->is_weekly_event = 1;
        $event->save();

        $this->updateMedia($event, $request);
        $this->updateTicket($event, $request);
        $this->updateTable($event, $request);
        $this->updateGuestlist($event, $request);
        $this->updateDjs($event->id, $request->djs);

        return redirect()->route('admin.events.index');
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
                    'approval' =>  $request->table_booking_approval[$i] ?? 'No',
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
                    'approval' =>  $request->guestlist_booking_approval[$i] ?? 'No',
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
        return redirect()->route('admin.events.index');
    }
}
