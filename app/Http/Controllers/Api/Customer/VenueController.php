<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\StripeAccount;
use App\Models\Ticket;
use App\Models\UserFavorite;
use App\Models\Venue;
use App\Models\VenueBooking;
use App\Models\VenueCity;
use App\Models\VenueMessage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stripe\Stripe;

class VenueController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $venues = DB::table('venues')
            ->select('venues.*', 'user_favorites.id as favourite')
            ->leftJoin('user_favorites', function ($join) use ($user_id) {
                $join->on('user_favorites.order_id', '=', 'venues.id')
                    ->where('user_favorites.user_id', '=', $user_id)
                    ->where('user_favorites.type', '=', 'venue');
            })
            ->where('status', 'Approved')
            ->get();

        return json_encode(array('success' => true, 'venues' => $venues));
    }

    public function favorites()
    {
        $user_id = Auth::user()->id;

        $venues = DB::table('venues')
            ->select('venues.*', 'user_favorites.id as favourite')
            ->join('user_favorites', function ($join) {
                $join->on('user_favorites.order_id', '=', 'venues.id')
                    ->where('user_favorites.type', '=', 'venue');
            })
            ->where('user_favorites.user_id', $user_id)
            ->get();
        
        return json_encode(array('success' => true, 'venues' => $venues));
    }

    public function add_favorite($venue_id)
    {
        $user_id = Auth::user()->id;
        $venue = Venue::where('id', $venue_id)->first();
        if (is_null($venue)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get venue'));
        }
        $favorite = array([
            'user_id' => $user_id,
            'order_id' => $venue_id,
            'type' => 'venue'
        ]);
        UserFavorite::upsert($favorite, ['user_id', 'order_id'], ['user_id', 'order_id', 'type']);
        return json_encode(array('success' => true));
    }

    public function remove_favorite($venue_id)
    {
        $user_id = Auth::user()->id;
        $venue = Venue::where('id', $venue_id)->first();
        if (is_null($venue)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get venue'));
        }
        UserFavorite::where('user_id', $user_id)
            ->where('order_id', $venue_id)
            ->where('type', 'venue')
            ->delete();
        return json_encode(array('success' => true));
    }

    public function venue($id)
    {
        $venue = Venue::where('id', $id)->first();
        $events = Event::where('venue_id', $id)->get();
        if (is_null($venue)) {
            return json_encode(array('success' => false, 'venue' => 'Failed to get venue'));
        }
        return json_encode(array('success' => true, 'venue' => $venue, 'events' => $events));
    }

   public function booking($id)
   {
        $user_id = Auth::user()->id;
        $intent = Auth::user()->createSetupIntent();

        $booking = DB::table('venue_bookings')
            ->join('venues', 'venues.id', '=', 'venue_bookings.venue_id')
            ->join('users', 'users.id', '=', 'venue_bookings.user_id')
            ->leftjoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')
            ->where('venue_bookings.id', $id)
            ->select('venue_bookings.*', 'user_profiles.address as address', 'users.name as username', 'venues.name as venuename')
            ->first();

        if (is_null($booking)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        } 
        return json_encode(array('success' => true, 'booking' => $booking, 'intent' => $intent));
   } 

    public function createBooking(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'venue_id' => 'required',
            'booking_type' => ['required', Rule::in(['Table', 'Offer'])],
            'type' => 'required',
            'price' => 'required',
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['required', 'date_format:H:i:s'],
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $venue = Venue::where('id', $request->venue_id)->first();
        if (is_null($venue)) {
            return json_encode(array('success' => false, 'error' => 'Failed to create booking'));
        }

        try {
            DB::beginTransaction();

            $booking = VenueBooking::create([
                'user_id' => $user_id,
                'venue_id' => $request->venue_id,
                'booking_type' => $request->booking_type,
                'type' => $request->type,
                'price' => $request->price,
                'date' => $request->date,
                'time' => $request->time,
            ]);

            $qrcode = json_encode(array(
                'user_id' => $user_id,
                'booking_id' => $booking->id,
            ));
            $image = QrCode::format('png')
                ->size(300)->errorCorrection('H')
                ->generate($qrcode);
            $file_name = Str::uuid() . '.png';
            $output_file = 'public/qrcodes/' . $file_name;
            Storage::disk('local')->put($output_file, $image);
            
            $ticket = new Ticket;
            $ticket->member_id = $booking->id;
            $ticket->type = 'venue';
            $ticket->ticket_code = $qrcode;
            $ticket->ticket_img_url = url('/') . Storage::url($output_file);
            $ticket->save();
    
            DB::commit();
            return json_encode(array('success' => true, 'booking' => $booking, 'ticket' => $ticket));
        
        } catch (Exception $e) {
            DB::rollBack();
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function ticket(Request $request)
    {
        $ticket = $request->ticket;
        $result = Ticket::where('ticket_code', $ticket)->where('is_scanned', 0)->count();
        if ($result == 0) {
            return json_encode(array('result' => 'reject'));
        } else {
            DB::table('tickets')->where('ticket_code', $ticket)->update(['is_scanned' => 1]);
            return json_encode(array('result' => 'approved'));
        }
    }

    public function purchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paymentMethodId' => 'required',
            'price' => 'required|numeric',
            'vendor_id' => 'required',
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }
        try {
            $user = Auth::user();
            $stripeAccount = StripeAccount::where('user_id', $request->vendor_id)->first();
            if (is_null($stripeAccount)) {
                return json_encode(array('success' => false, 'error' => 'Failed to get stripe account.'));
            }
            Stripe::setApiKey($stripeAccount->key);

            $stripeCharge = $user->charge(
                $request->price * 100,
                $request->paymentMethodId
            );

            return json_encode(array('success' => true));
        }
        catch (Exception $e) {
            return json_encode(array('success' => false, 'error' => $e->getMessage()));
        }
    }

    public function createMessage(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'venue_id' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $venue = Venue::where('id', $request->venue_id)->first();
        if (is_null($venue)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get venue'));
        }

        $message = VenueMessage::create([
            'user_id' => $user_id,
            'venue_id' => $request->venue_id,
            'message' => $request->message,
        ]);

        return json_encode(array('success' => true, 'message' => $message));
    }

    public function filterCity($id)
    {
        $city = VenueCity::where('id', $id)->first();
        if (is_null($city)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get venues'));
        }
        $venues = DB::table('venues')
            ->join('venue_cities', 'venue_cities.name', '=', 'venues.city')
            ->where('venue_cities.id', $id)
            ->where('venues.status', 'Approved')
            ->select('venues.*')
            ->get();

        return json_encode(array('success' => true, 'venues' => $venues));
    }
}
