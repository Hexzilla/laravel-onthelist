<?php

namespace App\Http\Controllers\Api\Dj;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\User;
use App\Models\EventDj;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        if (is_null($user)) {
            return json_encode(array('success' => false, 'error' => 'Failed to get event'));
        }
        $current = Carbon::now();
        if ($user->dj) {
            $events = DB::table('event_djs')
            ->join('events', 'events.id', '=', 'event_djs.event_id')
            ->where('event_djs.dj_id', $user->dj->id)
            ->where('events.start', '>', $current)
            ->select('events.*')
            ->get();
        } else {
            $events = array();
        }
        
        return json_encode(array('success' => true, 'events' => $events));
    }
}
