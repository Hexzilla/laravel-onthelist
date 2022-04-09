<?php

namespace App\Http\Controllers\Dj;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\EventDj;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $lists = EventDj::where('user_id', $user_id)->get();
        $size = count($lists);
        $current = Carbon::now();
        $events = array();
        $i = 0;
        foreach ($lists as $list)
        {
            $event = Event::where('id', $list->event_id)->where('start', '>', $current)->get();
            if(count($event) > 0){
                $events[$i] = $event[0];
                $i++;
            }
        }
        return view('dj.event', ['events' => $events]);
    }
}
