<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\EventDj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'customer')->paginate(10);
        return view("admin.user.list", ['users' => $users, 'role' => 'customer']);
    }

    public function edit($id)
    {
        $users = User::where('id', $id)->get();
        $user = $users[0];
        return view("admin.user.edit", ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $users = User::where('id', $id)->get();
        $user = $users[0];
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        $users = User::where('role', $user->role)->get();
        return view("admin.user.list", ['users' => $users, 'role' => $user->role ]);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $current = Carbon::now();

        if(!$user->dj) {
            return redirect()->back();
        }

        $events = DB::table('event_djs')
            ->join('events', 'events.id', '=', 'event_djs.event_id')
            ->where('event_djs.dj_id', $user->dj->id)
            ->where('events.start', '>', $current)
            ->select('events.*')
            ->get();
        
        return view("admin.user.show", ['events' => $events, 'user' => $user]);
    }

    public function approve($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->status = 'Approved';
        $user->save();
        return redirect()->back();
    }

    public function reject($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->status = 'Rejected';
        $user->save();
        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->delete();
        return redirect()->back();
    }
}
