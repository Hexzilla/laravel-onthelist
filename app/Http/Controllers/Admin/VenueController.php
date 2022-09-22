<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\VenueMedia;
use App\Models\VenueOffer;
use App\Models\VenueTable;
use App\Models\VenueTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Notification;
use App\Notifications\Approved;
use Illuminate\Validation\Rule;
use App\Rules\VenueTableRule;
use App\Rules\VenueOfferRule;
use App\Models\VenueCity;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::paginate(10);
        return view('admin.venue.list', [
            'breadcrumb' => 'All',
            'venues' => $venues
        ]);
    }

    public function featured()
    {
        $venues = Venue::where('feature', 'yes')->paginate(10);
        return view('admin.venue.list', [
            'breadcrumb' => 'Featured',
            'venues' => $venues
        ]);
    }

    public function edit($id)
    {
        $cities = DB::table('venue_cities')->get();
        $venue = Venue::where('id', $id)->firstOrFail();

        if (is_null($venue)) {
            return redirect()->route('admin.venues.index');
        }

        return view('admin.venue.edit', [
            'title' => 'Edit',
            'action' => route('admin.venues.update', $id),
            'cities' => $cities,
            'venue' => $venue,
        ]);
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
            'table_type' => ['required', 'array', Rule::in(['Type 1', 'Type 2', 'Type 3']), new VenueTableRule],
            'table_id' => 'required',
            'table_qty' => 'required|array',
            'table_price' => 'required|array',
            'table_approval' => ['required', 'array', Rule::in(['Yes', 'No'])],
            'table_description' => 'required|array',
            'offer_type' => ['required', 'array', Rule::in(['Discount', 'Type 2', 'Type 3']), new VenueOfferRule],
            'offer_id' => 'required|array',
            'offer_qty' => 'required|array',
            'offer_price' => 'required|array',
            'offer_approval' => ['required', 'array', Rule::in(['Yes', 'No'])],
            'offer_description' => 'required|array',
        ]);

        $venues = Venue::where('id', $id)->get();
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

        return redirect()->route('admin.venues.index')->with('Success');
    }

    public function updateTimetable($venue, $request)
    {
        $timetable = VenueTimetable::where('venue_id', $venue->id)->firstOrFail();
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
        if($request->hasFile('gallery_image'))
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
                    'approval' =>  $request->table_approval[$i] ?? 'No',
                    'description' =>  $request->table_description[$i],
                ]);
            }
            VenueTable::upsert($tables, ['id'], ['type', 'qty', 'price', 'approval', 'description']);
        }
    }

    public function destroy($id)
    {
        $venues = Venue::where('id', $id)->get();
        $venues[0]->delete();
        return redirect()->route('admin.venues.index')->with('Success');
    }

    public function feature($id)
    {
        $venues = Venue::where('id', $id)->get();
        $venue = $venues[0];
        $venue->feature = 'yes';
        $venue->save();
        return redirect()->route('admin.venues.index')->with('Success');
    }

    public function unfeature($id)
    {
        $venues = Venue::where('id', $id)->get();
        $venue = $venues[0];
        $venue->feature = 'no';
        $venue->save();
        return redirect()->route('admin.venues.index')->with('Success');
    }

    public function approve($id)
    {
        $venue = Venue::where('id', $id)->first();

        $user = User::where('id', $venue->user_id)->firstOrFail();

        $details = [
            'title' => 'Venue Approved',
            'description' => 'Admin approved your venue ' . $venue->name,
            'type' => 'venue',
            'user_id' => $venue->user_id,
            'item_id' => $venue->id,
        ];
        Notification::send($user, new Approved($details));

        $venue->status = 'Approved';
        $venue->save();
        return redirect()->back();
    }

    public function reject($id)
    {
        $venue = Venue::where('id', $id)->first();
        $venue->status = 'Rejected';
        $venue->save();
        return redirect()->back();
    }

    public function addCity()
    {
        return view('admin.venue.city', [
            'action' => route('admin.venues.city')
        ]);
    }

    public function storeCity(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $city = VenueCity::where('name', $request->name)->first();
        if (is_null($city)) {
            $city = VenueCity::create([
                'name' => $request->name
            ]);
        }
        
        if (!is_null($request->file('header_image'))) {
            $city->image = upload_file($request->file('header_image'), 'venue');
        }
        $city->save();

        return redirect()->route('admin.venues.index')->with('Success');
    }

    public function filterCity($id)
    {
        $city = VenueCity::where('id', $id)->first();
        $venues = DB::table('venues')
            ->join('venue_cities', 'venue_cities.name', '=', 'venues.city')
            ->where('venue_cities.id', $id)
            ->select('venues.*')
            ->get();

        return view('admin.venue.list', [
            'breadcrumb' => $city->name,
            'venues' => $venues
        ]);
    }

    public function upload($id)
    {
        $venue = Venue::where('id', $id)->first();
        if (is_null($venue)) {
            return redirect()->back();
        }

        return view('admin.venue.upload', [
            'venue' => $venue
        ]);
    }

    public function uploadImage(Request $request, $id)
    {
        $venue = Venue::where('id', $id)->first();
        
        if (is_null($venue)) {
            return redirect()->back();
        }

        if (!is_null($request->file('feature_image'))) {
            $venue->feature_image_path = upload_file($request->file('feature_image'));
            $venue->save();
        }
        return redirect()->route('admin.venues.index');
    }
}
