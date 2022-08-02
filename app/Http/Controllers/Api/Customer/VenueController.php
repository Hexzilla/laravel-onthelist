<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venue;
use App\Models\UserFavorite;
use App\Models\VenueBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Cashier\Stripe;

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
            ->paginate(10);

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
            ->paginate(10);
        
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

    public function booking($id)
    {
        $venue = Venue::where('id', $id)->first();
        if (is_null($venue)) {
            return json_encode(array('success' => false, 'venue' => 'Failed to get venue'));
        }
        return json_encode(array('success' => true, 'venue' => $venue));
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
            'time' => ['required', 'date_format:H:i'],
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $venue = Venue::where('id', $request->venue_id)->first();
        if (is_null($venue)) {
            return json_encode(array('success' => false, 'error' => 'Failed to create booking'));
        }

        VenueBooking::create([
            'user_id' => $user_id,
            'venue_id' => $request->venue_id,
            'booking_type' => $request->booking_type,
            'type' => $request->type,
            'price' => $request->price,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return json_encode(array('success' => true));
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
}
