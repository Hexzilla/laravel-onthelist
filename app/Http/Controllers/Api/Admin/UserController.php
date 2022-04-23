<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\EventDj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'customer')->paginate(10);
        return json_encode(array('success' => true, 'users' => $users));
    }

    public function edit($id)
    {
        $users = User::where('id', $id)->get();
        $user = $users[0];
        return json_encode(array('success' => true, 'user' => $user));
    }

    public function update(Request $request, $id)
    {
        $users = User::where('id', $id)->get();
        $user = $users[0];
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|email',
            "role" => 'required',
        ]);

        if ($validator->fails()) {
            return json_encode(array('success' => false, 'error' => $validator->errors()));
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        return json_encode(array('success' => true));
    }

    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $current = Carbon::now();

        if (!$user->dj) {
            return json_encode(array('success' => false, 'error' => 'Failed to get events'));
        }
        $events = DB::table('event_djs')
            ->join('events', 'events.id', '=', 'event_djs.event_id')
            ->where('event_djs.dj_id', $user->dj->id)
            ->where('events.start', '>', $current)
            ->select('events.*')
            ->get();
        
        return json_encode(array('success' => true, 'events' => $events, 'user' => $user));
    }

    public function approve($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->status = 'Approved';
        $user->save();
        return json_encode(array('success' => true));
    }

    public function reject($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->status = 'Rejected';
        $user->save();
        return json_encode(array('success' => true));
    }
}
