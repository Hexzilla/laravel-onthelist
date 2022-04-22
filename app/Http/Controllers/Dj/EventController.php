<?php

namespace App\Http\Controllers\Dj;

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
        $user = User::where('id', $user_id)->firstOrFail();
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
        
        return view('dj.event', ['events' => $events]);
    }
}
