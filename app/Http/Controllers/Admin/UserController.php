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
    public function index($role)
    {
        $users = User::where('role', $role)->paginate(10);
        if ($role == 'vendor') {
            return view("admin.vendor.list", ['users' => $users, 'role' => $role]);    
        }
        return view("admin.user.list", ['users' => $users, 'role' => $role]);
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

        $events = DB::table('event_djs')
            ->join('events', 'events.id', '=', 'event_djs.event_id')
            ->where('event_djs.user_id', $id)
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
}
