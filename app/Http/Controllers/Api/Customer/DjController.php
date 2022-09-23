<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Dj;
use App\Models\DjMedia;
use App\Models\DjMessage;
use App\Models\UserFavorite;
use Illuminate\Support\Facades\Validator;

class DjController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $djs = DB::table('djs')
            ->select('djs.*', 'user_favorites.id as favourite')
            ->leftJoin('user_favorites', function ($join) use ($user_id) {
                $join->on('user_favorites.order_id', '=', 'djs.id')
                    ->where('user_favorites.user_id', '=', $user_id)
                    ->where('user_favorites.type', '=', 'dj');
            })
            ->get();

        return json_encode(array('success' => true, 'djs' => $djs));
    }

    public function get($dj_id)
    {
        $dj = Dj::where('id', $dj_id)->first();
        $media = DjMedia::where('dj_id', $dj_id)->get();
        $events = DB::table('events')
            ->join('event_djs', 'event_djs.event_id', '=', 'events.id')
            ->where('event_djs.dj_id', $dj_id)
            ->get();
        
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get dj'));
        }

        return json_encode(array('success' => true, 'dj' => $dj, 'media' => $media, 'events' => $events));
    }

    public function favourites()
    {
        $user_id = Auth::user()->id;

        $djs = DB::table('djs')
            ->select('djs.*', 'user_favorites.id as favourite')
            ->leftJoin('user_favorites', function ($join) use ($user_id) {
                $join->on('user_favorites.order_id', '=', 'djs.id')
                    ->where('user_favorites.user_id', '=', $user_id)
                    ->where('user_favorites.type', '=', 'dj');
            })
            ->where('user_favorites.user_id', $user_id)
            ->get();

        return json_encode(array('success' => true, 'djs' => $djs));
    }

    public function add_favorite($dj_id)
    {
        $user_id = Auth::user()->id;
        $dj = Dj::where('id', $dj_id)->first();
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get dj'));
        }
        $favorite = array([
            'user_id' => $user_id,
            'order_id' => $dj_id,
            'type' => 'dj'
        ]);
        UserFavorite::upsert($favorite, ['user_id', 'order_id'], ['user_id', 'order_id', 'type']);
        return json_encode(array('success' => true));
    }

    public function remove_favorite($dj_id)
    {
        $user_id = Auth::user()->id;
        $dj = Dj::where('id', $dj_id)->first();
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        UserFavorite::where('user_id', $user_id)
            ->where('order_id', $dj_id)
            ->where('type', 'dj')
            ->delete();
        return json_encode(array('success' => true));
    }

    public function createMessage(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'dj_id' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }

        $dj = Dj::where('id', $request->dj_id)->first();
        if (is_null($dj)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get dj'));
        }

        $message = DjMessage::create([
            'user_id' => $user_id,
            'dj_id' => $request->dj_id,
            'message' => $request->message,
        ]);

        return json_encode(array('success' => true, 'message' => $message));
    }
}
