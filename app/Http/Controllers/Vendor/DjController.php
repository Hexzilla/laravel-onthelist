<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Dj;
use App\Models\Venue;
use App\Models\VenueMedia;
use App\Models\VenueOffer;
use App\Models\VenueTable;
use App\Models\VenueTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DjController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $djs = Dj::where('user_id', $user_id)->get();
        return view('vendor.dj.list', ['djs' => $djs]);
    }

    public function create()
    {
        return view('vendor.dj.create', [
            'title' => 'Create',
            'action' => route('vendors.venue.store'),
            'dj' => NULL,
        ]);
    }

    public function edit($id)
    {
        $user_id = Auth::user()->id;
        $venue = Venue::where('user_id', $user_id)->where('id', $id)->firstOrFail();

        if (is_null($venue)) {
            return redirect()->route('vendors.venue.index');
        }

        return view('vendor.dj.create', [
            'title' => 'Edit',
            'action' => route('vendors.venue.update', $id),
            'venue' => $venue,
        ]);
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'header_image' => 'required|mimes:jpeg,png,jpg,gif',
            'address' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'venue_type' => 'required',
        ]);

        $venue = new Venue();
        $venue->user_id = $user_id;
        $venue->name = $request->name;
        $venue->type = $request->venue_type;
        if (!is_null($request->details))
            $venue->description = $request->details;
        $venue->header_image_path = upload_file($request->file('header_image'), 'venue');
        $venue->address = $request->address;
        $venue->city = $request->city;
        $venue->postcode = $request->postcode;
        $venue->phone = $request->phone;
        if (!is_null($request->facilities))
            $venue->facilities = $request->facilities;
        if (!is_null($request->music_policy))
            $venue->music_policy = $request->music_policy;
        if (!is_null($request->dress_code))
            $venue->dress_code = $request->dress_code;
        if (!is_null($request->perks))
            $venue->perks = $request->perks;
        $venue->save();

        $this->createTimetable($venue, $request);
        $this->createMedia($venue, $request);
        $this->createOffer($venue, $request);
        $this->createTable($venue, $request);

        return redirect()->route('vendors.venue.index');
    }

    public function createTimetable($venue, $request)
    {
        VenueTimetable::create([
            'venue_id' => $venue->id,
            'mon_open' => $request->mon_open,
            'mon_close' => $request->mon_close,
            'tue_open' => $request->tue_open,
            'tue_close' => $request->tue_close,
            'wed_open' => $request->wed_open,
            'wed_close' => $request->wed_close,
            'thu_open' => $request->thu_open,
            'thu_close' => $request->thu_close,
            'fri_open' => $request->fri_open,
            'fri_close' => $request->fri_close,
            'sat_open' => $request->sat_open,
            'sat_close' => $request->sat_close,
            'sun_open' => $request->sun_open,
            'sun_close' => $request->sun_close,
        ]);
    }

    public function createMedia($venue, $request)
    {
        if ($request->hasFile('gallery_image'))
        {
            $path = upload_file($request->file('gallery_image'), 'venue');
            VenueMedia::create([
                'venue_id' => $venue->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // create media record if the video exists
        if ($request->hasFile('gallery_video'))
        {
            $path = upload_file($request->file('gallery_video'), 'venue');
            VenueMedia::create([
                'venue_id' => $venue->id,
                'type' => 'video',
                'path' => $path
            ]);
        }

        if (!is_null($request->video_link))
        {
            VenueMedia::create([
                'venue_id' => $venue->id,
                'type' => 'link',
                'path' => $request->video_link
            ]);
        }
    }

    public function createOffer($venue, $request)
    {
        if ($request->has('offer_type'))
        {
            $offerSize = sizeof($request->get('offer_type'));
            for ($i = 0; $i < $offerSize; $i++) {
                VenueOffer::create([
                    'venue_id' => $venue->id,
                    'type' => $request->offer_type[$i],
                    'qty' => $request->offer_qty[$i] || 0,
                    'price' => $request->offer_price[$i] || 0,
                    'approval' => $request->offer_approval[$i],
                    'description' => $request->offer_description[$i]
                ]);
            }
        }
    }

    public function createTable($venue, $request)
    {
        if ($request->has('table_type'))
        {
            $tableSize = sizeof($request->get('table_type'));
            for ($i = 0; $i < $tableSize; $i++){
                VenueTable::create([
                    'venue_id' => $venue->id,
                    'type' => $request->table_type[$i],
                    'qty' => $request->table_qty[$i] || 0,
                    'price' => $request->table_price[$i] || 0,
                    'approval' => $request->table_booking_approval[$i],
                    'description' => $request->table_description[$i]
                ]);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'venue_type' => 'required'
        ]);

        $venues = Venue::where('user_id', $user_id)->where('id', $id)->get();
        $venue = $venues[0];
        $venue->user_id = $user_id;
        $venue->name = $request->name;
        $venue->type = $request->venue_type;
        if (!is_null($request->details)) {
            $venue->description = $request->details;
        }
        if (!is_null($request->file('header_image'))) {
            $venue->header_image_path = upload_file($request->file('header_image'), 'venue');
        }
        $venue->address = $request->address;
        $venue->city = $request->city;
        $venue->postcode = $request->postcode;
        $venue->phone = $request->phone;
        if (!is_null($request->facilities)) {
            $venue->facilities = $request->facilities;
        }
        if (!is_null($request->music_policy)) {
            $venue->music_policy = $request->music_policy;
        }
        if (!is_null($request->dress_code)) {
            $venue->dress_code = $request->dress_code;
        }
        if (!is_null($request->perks)) {
            $venue->perks = $request->perks;
        }
        $venue->save();

        $this->updateTimetable($venue, $request);
        $this->updateMedia($venue, $request);
        $this->updateOffer($venue, $request);
        $this->updateTable($venue, $request);

        return redirect()->route('vendors.venue.index');
    }

    public function updateTimetable($venue, $request)
    {
        $timetables = VenueTimetable::where('venue_id', $venue->id)->get();
        $timetable = $timetables[0];
        $timetable->mon_open = $request->mon_open;
        $timetable->mon_close = $request->mon_close;
        $timetable->tue_open = $request->tue_open;
        $timetable->tue_close = $request->tue_close;
        $timetable->wed_open = $request->wed_open;
        $timetable->wed_close = $request->wed_close;
        $timetable->thu_open = $request->thu_open;
        $timetable->thu_close = $request->thu_close;
        $timetable->fri_open = $request->fri_open;
        $timetable->fri_close = $request->fri_close;
        $timetable->sat_open = $request->sat_open;
        $timetable->sat_close = $request->sat_close;
        $timetable->sun_open = $request->sun_open;
        $timetable->sun_close = $request->sun_close;
        $timetable->save();
    }

    public function updateMedia($venue, $request)
    {
        if ($request->hasFile('gallery_image'))
        {
            $path = upload_file($request->file('gallery_image'), 'venue');
            VenueMedia::create([
                'venue_id' => $venue->id,
                'type' => 'image',
                'path' => $path
            ]);
        }

        // update media record if the video exists
        if ($request->hasFile('gallery_video'))
        {
            $path = upload_file($request->file('gallery_video'), 'venue');
            VenueMedia::create([
                'venue_id' => $venue->id,
                'type' => 'video',
                'path' => $path
            ]);
        }

        if (!is_null($request->video_link))
        {
            VenueMedia::create([
                'venue_id' => $venue->id,
                'type' => 'link',
                'path' => $request->video_link
            ]);
        }
    }

    public function updateOffer($venue, $request)
    {
        if ($request->has('offer_type'))
        {
            $offerIds = $request->get('offer_id');
            $offerIds = array_filter($offerIds, function($id) {
                return isset($id);
            });
            if (count($offerIds) > 0) {
                VenueOffer::where('venue_id', $venue->id)->whereNotIn('id', $offerIds)->delete();
            } else {
                VenueOffer::where('venue_id', $venue->id)->delete();
            }

            $offerSize = sizeof($request->get('offer_type'));
            $offers = array();
            for ($i = 0; $i < $offerSize; $i++){
                array_push($offers, [
                    'id' => $request->offer_id[$i],
                    'venue_id' => $venue->id,
                    'type' => $request->offer_type[$i],
                    'qty' => $request->offer_qty[$i],
                    'price' => $request->offer_price[$i],
                    'approval' => $request->offer_approval[$i],
                    'description' => $request->offer_description[$i]
                ]);
            }
            VenueOffer::upsert($offers, ['id'], ['type', 'qty', 'price', 'approval', 'description']);
        }
    }

    public function updateTable($venue, $request)
    {
        if ($request->has('table_type'))
        {
            $tableIds = $request->get('table_id');
            $tableIds = array_filter($tableIds, function($id) {
                return isset($id);
            });
            if (count($tableIds) > 0) {
                VenueTable::where('venue_id', $venue->id)->whereNotIn('id', $tableIds)->delete();
            } else {
                VenueTable::where('venue_id', $venue->id)->delete();
            }

            $tableSize = sizeof($request->get('table_type'));
            $tables = array();
            for ($i = 0; $i < $tableSize; $i++) {
                array_push($tables, [
                    'id' =>  $request->table_id[$i],
                    'venue_id' => $venue->id,
                    'type' =>  $request->table_type[$i] ?? 'Standard',
                    'qty' =>  $request->table_qty[$i] ?? 0,
                    'price' =>  $request->table_price[$i] ?? 0,
                    'approval' =>  $request->table_booking_approval[$i] ?? 'No',
                    'description' =>  $request->table_description[$i],
                ]);
            }
            VenueTable::upsert($tables, ['id'], ['type', 'qty', 'price', 'approval', 'description']);
        }
    }

    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $venues = Venue::where('user_id', $user_id)->where('id', $id)->get();
        $venues[0]->delete();
        return redirect()->route('vendors.venue.index')->with('Success');
    }
}