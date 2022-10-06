<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Booking;
use App\Models\EventMessage;
use App\Models\StripeAccount;
use App\Models\Ticket;
use App\Models\UserFavorite;
use App\Models\VenueCity;
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

class EventController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $events = DB::table('events')
            ->select('events.*', 'user_favorites.id as favourite')
            ->leftJoin('user_favorites', function ($join) use ($user_id) {
                $join->on('user_favorites.order_id', '=', 'events.id')
                    ->where('user_favorites.user_id', '=', $user_id)
                    ->where('user_favorites.type', '=', 'event');
            })
            ->where('status', 'Approved')->get();

        return json_encode(array('success' => true, 'events' => $events));
    }

    public function favorites()
    {
        $user_id = Auth::user()->id;

        $events = DB::table('events')
            ->select('events.*', 'user_favorites.id as favourite')
            ->join('user_favorites', function ($join) {
                $join->on('user_favorites.order_id', '=', 'events.id')
                    ->where('user_favorites.type', '=', 'event');
            })
            ->where('user_favorites.user_id', $user_id)
            ->get();
        
        return json_encode(array('success' => true, 'events' => $events));
    }

    public function add_favorite($event_id)
    {
        $user_id = Auth::user()->id;
        $event = Event::where('id', $event_id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        $favorite = array([
            'user_id' => $user_id,
            'order_id' => $event_id,
            'type' => 'event'
        ]);
        UserFavorite::upsert($favorite, ['user_id', 'order_id'], ['user_id', 'order_id', 'type']);
        return json_encode(array('success' => true));
    }

    public function remove_favorite($event_id)
    {
        $user_id = Auth::user()->id;
        $event = Event::where('id', $event_id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        UserFavorite::where('user_id', $user_id)
            ->where('order_id', $event_id)
            ->where('type', 'event')
            ->delete();
        return json_encode(array('success' => true));
    }

    public function event($id)
    {
        $event = Event::where('id', $id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        return json_encode(array('success' => true, 'event' => $event));
    }

    public function booking($id)
    {
        $user_id = Auth::user()->id;
        $intent = Auth::user()->createSetupIntent();

        $booking = DB::table('bookings')
            ->join('events', 'events.id', '=', 'bookings.event_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'bookings.user_id')
            ->where('bookings.id', $id)
            ->select('bookings.*', 'user_profiles.address as address', 'users.name as username', 'events.name as eventname')
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
            'event_id' => 'required',
            'booking_type' => ['required', Rule::in(['Ticket', 'Table', 'Guestlist'])],
            'qty' => 'required',
            'type' => ['required', Rule::in(['Standard', 'EarlyBird', 'VIP'])],
            'price' => 'required',
            'date' => ['required', 'date_format:Y-m-d'],
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $event = Event::where('id', $request->event_id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to create booking'));
        }

        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'user_id' => $user_id,
                'event_id' => $request->event_id,
                'booking_type' => $request->booking_type,
                'qty' => $request->qty,
                'type' => $request->type,
                'price' => $request->price,
                'date' => $request->date,
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
            $ticket->type = 'event';
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

    public function filter_date(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date']
        ]);
        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }
        $date = Date($request->date);

        $events = Event::where('end', '>', $date)
            ->whereDate('start', '<', $date)
            ->orWhereDate('start', '=', $date)
            ->where('status', 'Approved')->get();
        
        return json_encode(array('success' => true, 'events' => $events));
    }

    public function createMessage(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $event = Event::where('id', $request->event_id)->first();
        if (is_null($event)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }

        $message = EventMessage::create([
            'user_id' => $user_id,
            'event_id' => $request->event_id,
            'message' => $request->message,
        ]);

        return json_encode(array('success' => true, 'message' => $message));
    }

    public function filterCity($id)
    {
        $city = VenueCity::where('id', $id)->first();
        if (is_null($city)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get events'));
        }

        $events = DB::table('events')
            ->join('venues', 'venues.id', '=', 'events.venue_id')
            ->join('venue_cities', 'venue_cities.name', '=', 'venues.city')
            ->where('venue_cities.id', $id)
            ->where('events.status', 'Approved')
            ->select('events.*')
            ->get();

        return json_encode(array('success' => true, 'events' => $events));
    }
}
