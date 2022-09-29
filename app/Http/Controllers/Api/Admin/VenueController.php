<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\VenueCity;
use App\Models\VenueMedia;
use App\Models\VenueOffer;
use App\Models\VenueTable;
use App\Models\VenueTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Notification;
use App\Notifications\Approved;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\VenueTableRule;
use App\Rules\VenueOfferRule;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::paginate(10);
        $cities = VenueCity::get();
        return json_encode(array('success' => true, 'venues' => $venues, 'cities' => $cities));
    }

    public function featured()
    {
        $venues = Venue::where('feature', 'yes')->paginate(10);
        $cities = VenueCity::get();
        return json_encode(array('success' => true, 'venues' => $venues, 'cities' => $cities));
    }

    public function edit($id)
    {
        $venue = Venue::where('id', $id)->firstOrFail();
        $cities = VenueCity::get();

        if (is_null($venue)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get venue'));
        }

        return json_encode(array('success' => true, 'venue' => $venue, 'cities' => $cities));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'mon_open' => 'required',
            'mon_close' => 'required',
            'tue_open' => 'required',
            'tue_close' => 'required',
            'wed_open' => 'required',
            'wed_close' => 'required',
            'thu_open' => 'required',
            'thu_close' => 'required',
            'fri_open' => 'required',
            'fri_close' => 'required',
            'sat_open' => 'required',
            'sat_close' => 'required',
            'sun_open' => 'required',
            'sun_close' => 'required',
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
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $venues = Venue::where('id', $id)->get();
        $venue = $venues[0];
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

        return json_encode(array('success' => true));
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
        return json_encode(array('success' => true));
    }

    public function feature($id)
    {
        $venues = Venue::where('id', $id)->get();
        $venue = $venues[0];
        $venue->feature = 'yes';
        $venue->save();
        return json_encode(array('success' => true));
    }

    public function unfeature($id)
    {
        $venues = Venue::where('id', $id)->get();
        $venue = $venues[0];
        $venue->feature = 'no';
        $venue->save();
        return json_encode(array('success' => true));
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
        return json_encode(array('success' => true));
    }

    public function reject($id)
    {
        $venue = Venue::where('id', $id)->first();
        $venue->status = 'Rejected';
        $venue->save();
        return json_encode(array('success' => true));
    }

    public function storeCity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => 'Failed to add city'));
        }

        $city = VenueCity::create([
            'name' => $request->name
        ]);

        if (!is_null($request->file('header_image'))) {
            $city->header_image_path = upload_file($request->file('header_image'), 'venue');
        }
    }

    public function filterCity($id)
    {
        $venues = DB::table('venues')
            ->join('venue_cities', 'venue_cities.name', '=', 'venues.city')
            ->where('venue_cities.id', $id)
            ->get();
        
        return json_encode(array('success' => true, 'venues' => $venues));
    }
}
