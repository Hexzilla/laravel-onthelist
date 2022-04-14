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
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::get();
        return view('admin.event.list', [
            'breadcrumb' => 'All',
            'events' => $events
        ]);
    }

    public function upcoming()
    {
        $current = Carbon::now();
        $events = Event::where('start', '>', $current)->get();
        return view('admin.event.list', [
            'breadcrumb' => 'Upcoming',
            'events' => $events
        ]);
    }

    public function featured()
    {
        $events = Event::where('feature', 'yes')->get();
        return view('admin.event.list', [
            'breadcrumb' => 'Featured',
            'events' => $events
        ]);
    }

    public function complete()
    {
        $current = Carbon::now();
        $events = Event::where('end', '<', $current)->get();
        return view('admin.event.list', [
            'breadcrumb' => 'Complete',
            'events' => $events
        ]);
    }

    public function edit($id)
    {
        $events = Event::where('id', $id)->get();
        $event = $events[0];
        $user_id = $event->user_id;
        $djs = User::where('role', 'dj')->get();
        $venues = Venue::where('user_id', $user_id)->get();
        return view('admin.event.edit', ['event' => $event, 'venues' => $venues, 'djs' => $djs]);
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

        $events = Event::where('id', $id)->get();
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

        return redirect()->route('admin.events.index');
    }

    public function destroy($id)
    {
        $event = Event::where('id', $id)->get();
        $event[0] -> delete();
        $events = Event::get();
        return redirect()->route('admin.events.index');
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

    public function approve($id)
    {
        $event = Event::where('id', $id)->firstOrFail();
        if (is_null($event)) {
            return redirect()->back();
        }
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
}
