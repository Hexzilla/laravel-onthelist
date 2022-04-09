<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\EventDj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index($role)
    {
        $users = User::where('role', $role)->get();
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
        $lists = EventDj::where('user_id', $id)->get();
        $events = array();
        $i = 0;
        foreach($lists as $list)
        {
            $events[$i] = Event::where('id', $list->event_id)->first();
            $i++;
        }
        return view("admin.user.show", ['events' => $events, 'user' => $user]);
    }
}
